<?php

namespace App\Http\Controllers;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Employee Dashboard (Orders Overview)
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        // 10 Key Video Stat Cards
        $stats = [
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'refunded' => Order::where('status', 'refunded')->count(),
            'commissioned' => 0,
            'refunded_pending_review' => Order::where('status', 'refunded_pending_review')->count(),
            'reviewed' => Order::where('status', 'reviewed')->count(),
            'ordered' => Order::whereIn('status', ['pending', 'ordered', 'processing'])->count(),
            'review_submitted_refund' => Order::where('status', 'review_submitted_refund')->count(),
            'review_deleted' => Order::where('status', 'review_deleted')->count(),
            'on_hold' => Order::where('status', 'on_hold')->count(),
        ];

        // Completed Orders
        $completedOrders = Order::query()
            ->with(['items.product', 'user'])
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        // Orders by Status Breakdown
        $ordersByStatus = [
            'Ordered' => $stats['ordered'],
            'Reviewed' => $stats['reviewed'],
            'Refunded' => $stats['refunded'],
            'On Hold' => $stats['on_hold'],
            'Completed' => $stats['completed'],
            'Cancelled' => $stats['cancelled'],
        ];

        return view('employee.index', compact('stats', 'completedOrders', 'ordersByStatus', 'user'));
    }

    /**
     * Orders List with Status Filtering and Search
     */
    public function orders(Request $request, ?string $status = null): View
    {
        $query = Order::query()->with(['items.product', 'user'])->latest();

        if ($status && $status !== 'all') {
            $normalizedStatus = strtolower(str_replace('-', '_', $status));
            $query->where('status', $normalizedStatus);
        }

        if ($request->filled('customer_email')) {
            $email = trim($request->input('customer_email'));
            $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$email}%"));
        }

        if ($request->filled('product_id')) {
            $pid = trim($request->input('product_id'));
            $query->whereHas('items', fn($q) => $q->where('product_id', $pid));
        }

        if ($request->filled('order_number')) {
            $num = trim($request->input('order_number'));
            $query->where('order_number', 'like', "%{$num}%");
        }

        $orders = $query->paginate(15)->withQueryString();
        $currentStatus = $status ?? 'all';

        return view('employee.orders', compact('orders', 'currentStatus'));
    }

    /**
     * Products List by Category and Filters
     */
    public function products(Request $request, ?string $category = null): View
    {
        $query = AdminProduct::query()->with(['category', 'images'])->where('status', 'published')->latest();

        if ($category && $category !== 'all') {
            if ($category === 'favorites') {
                $favorites = session()->get('employee_favorites', []);
                $query->whereIn('id', $favorites);
            } else {
                $query->whereHas('category', function ($q) use ($category) {
                    $slug = strtolower(str_replace(['-', ' '], '_', $category));
                    $q->where('slug', 'like', "%{$slug}%")
                      ->orWhere('name', 'like', "%{$category}%");
                });
            }
        }

        if ($request->filled('product_code')) {
            $query->where('sku', 'like', '%' . trim($request->product_code) . '%')
                  ->orWhere('id', trim($request->product_code));
        }

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $kw = trim($request->keyword);
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('description', 'like', "%{$kw}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $currentCategory = $category ?? 'all';
        $favorites = session()->get('employee_favorites', []);

        return view('employee.products', compact('products', 'currentCategory', 'favorites'));
    }

    /**
     * Product Details (Amazon Layout from Video)
     */
    public function productDetail(int $id): View
    {
        $product = AdminProduct::with(['category', 'images'])->findOrFail($id);
        $favorites = session()->get('employee_favorites', []);
        $isFavorite = in_array($product->id, $favorites);

        return view('employee.product-detail', compact('product', 'isFavorite'));
    }

    /**
     * Toggle Favorite
     */
    public function toggleFavorite(int $id): RedirectResponse
    {
        $favorites = session()->get('employee_favorites', []);

        if (in_array($id, $favorites)) {
            $favorites = array_values(array_diff($favorites, [$id]));
            $msg = 'Product removed from favorites.';
        } else {
            $favorites[] = $id;
            $msg = 'Product added to favorites!';
        }

        session()->put('employee_favorites', $favorites);

        return back()->with('success', $msg);
    }

    /**
     * Active Reservations with Countdown Timer
     */
    public function reservations(): View
    {
        $user = Auth::user();
        $reservations = Reservation::query()
            ->with(['product.images'])
            ->where('user_id', $user->id)
            ->where('status', '!=', 'rejected')
            ->latest()
            ->get();

        return view('employee.reservations.index', compact('reservations'));
    }

    /**
     * Add New Reservation View
     */
    public function createReservation(): View
    {
        return view('employee.reservations.create');
    }

    /**
     * Store Reservation
     */
    public function storeReservation(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();

        // Check if already reserved
        $existing = Reservation::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('employee.reservations.index')->with('info', 'Product is already reserved by you.');
        }

        Reservation::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'status' => 'pending',
            'expires_at' => now()->addHours(2), // 2 hours countdown timer
        ]);

        return redirect()->route('employee.reservations.index')->with('success', 'Product reserved successfully!');
    }

    /**
     * Release Reservation
     */
    public function releaseReservation(int $id): RedirectResponse
    {
        $user = Auth::user();
        $reservation = Reservation::where('user_id', $user->id)->findOrFail($id);
        $reservation->delete();

        return redirect()->route('employee.reservations.index')->with('success', 'Reservation released successfully.');
    }

    /**
     * Create Order from Reservation
     */
    public function createOrderFromReservation(int $id): View
    {
        $reservation = Reservation::with('product')->findOrFail($id);
        return view('employee.reservations.create-order', compact('reservation'));
    }

    /**
     * Store Order created from Reservation
     */
    public function storeOrderFromReservation(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'order_number' => 'required|string|max:100',
            'paypal_email' => 'nullable|email',
            'order_pic' => 'nullable|image|max:4096',
            'refund_pic' => 'nullable|image|max:4096',
            'amz_review_link' => 'nullable|url',
        ]);

        $reservation = Reservation::with('product')->findOrFail($id);
        $user = Auth::user();

        $orderPicPath = $request->file('order_pic')?->store('orders', 'public');
        $refundPicPath = $request->file('refund_pic')?->store('refunds', 'public');

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $request->order_number,
            'subtotal' => $reservation->product->sale_price ?? $reservation->product->regular_price ?? 0,
            'total' => $reservation->product->sale_price ?? $reservation->product->regular_price ?? 0,
            'payment_status' => 'pending',
            'payment_method' => 'paypal',
            'status' => 'ordered',
            'shipping_name' => $user->name ?? 'Employee Reservation',
            'shipping_address' => $user->address ?? 'Direct Reservation Order',
            'payment_reference' => $request->paypal_email,
            'placed_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $reservation->product_id,
            'product_name' => $reservation->product->name,
            'quantity' => 1,
            'unit_price' => $order->total,
            'subtotal' => $order->total,
        ]);

        // Complete reservation
        $reservation->update(['status' => 'approved']);

        return redirect()->route('employee.orders', 'ordered')->with('success', 'Order created successfully from reservation!');
    }

    /**
     * Change Password Form
     */
    public function changePassword(): View
    {
        return view('employee.change-password');
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Current password does not match.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Employee Profile
     */
    public function profile(): View
    {
        $user = Auth::user();
        return view('employee.profile', compact('user'));
    }

    /**
     * Update Employee Profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Admins / Management Team List
     */
    public function admins(): View
    {
        $admins = [
            ['id' => 1, 'name' => 'Osama Ahmed', 'role' => 'Refund Manager', 'whatsapp' => '923001234567'],
            ['id' => 2, 'name' => 'Refund Admin', 'role' => 'Paypal Change & Order Verification & Manager', 'whatsapp' => '923007654321'],
            ['id' => 3, 'name' => 'Refund Manager', 'role' => 'Refund Manager', 'whatsapp' => '923112233445'],
            ['id' => 4, 'name' => 'Sajid Arif', 'role' => 'PM Recruitment & Commission issue resolution manager', 'whatsapp' => '923223344556'],
            ['id' => 5, 'name' => 'Dispute & Less refund manager', 'role' => 'Dispute & Less refunds Manager', 'whatsapp' => '923334455667'],
            ['id' => 6, 'name' => 'Muhammad Ubaid', 'role' => 'Scam & neg issues resolution manager', 'whatsapp' => '923445566778'],
            ['id' => 7, 'name' => 'Muhammad Majid', 'role' => 'Wrong Onhold/Cancelled orders resolution Manager', 'whatsapp' => null],
            ['id' => 8, 'name' => 'Main Admin', 'role' => 'Main Admin', 'whatsapp' => '923000000000'],
        ];

        return view('employee.admins', compact('admins'));
    }

    /**
     * Support Screen
     */
    public function support(): View
    {
        return view('employee.support');
    }

    /**
     * Check Blacklisted Paypal
     */
    public function blacklistedPaypal(Request $request): View
    {
        $search = $request->query('paypal_email');
        $isBlacklisted = null;
        $reason = null;

        if ($search) {
            $blacklistedList = [
                'scammer@example.com' => 'Multiple refund scams reported',
                'fakebuyer@gmail.com' => 'Chargeback abuse',
                'badpaypal@yahoo.com' => 'Unauthorized payment activity',
            ];

            if (array_key_exists(strtolower(trim($search)), $blacklistedList)) {
                $isBlacklisted = true;
                $reason = $blacklistedList[strtolower(trim($search))];
            } else {
                $isBlacklisted = false;
            }
        }

        return view('employee.paypal-blacklist', compact('search', 'isBlacklisted', 'reason'));
    }

    /**
     * Delay Refunds
     */
    public function delayRefunds(): View
    {
        $delayedOrders = Order::query()
            ->with(['items.product', 'user'])
            ->whereIn('status', ['on_hold', 'refunded_pending_review', 'review_submitted_refund'])
            ->latest()
            ->get();

        return view('employee.delay-refunds', compact('delayedOrders'));
    }

    /**
     * Create Excel View
     */
    public function createExcel(): View
    {
        return view('employee.excel');
    }

    /**
     * Generate Excel Download
     */
    public function generateExcel(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'order_status' => 'nullable|string',
        ]);

        $query = Order::query()
            ->with(['user', 'items'])
            ->whereDate('created_at', '>=', $request->from_date)
            ->whereDate('created_at', '<=', $request->to_date);

        if ($request->order_status) {
            $query->where('status', $request->order_status);
        }

        $orders = $query->latest('placed_at')->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'No orders found for the selected criteria.');
        }

        $rows = $orders->map(fn (\App\Models\Order $order): array => [
            $order->order_number,
            $order->user->name ?? '—',
            $order->placed_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
            $order->items->count(),
            number_format((float) $order->total, 2),
            $order->payment_method ?: '—',
            ucfirst($order->status),
        ])->all();

        \App\Services\XlsxExport::download(
            ['Order #', 'Customer', 'Date', 'Items', 'Total', 'Payment Method', 'Status'],
            $rows,
            'employee-orders-' . $request->from_date . '-to-' . $request->to_date . '.xlsx',
            'Filtered Orders'
        );
    }
}
