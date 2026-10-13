<?php

namespace App\Http\Controllers;

use App\Mail\OrderDeliveredEmail;
use App\Mail\OrderShippedEmail;
use App\Models\ActivityLog;
use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\ProductQuestion;
use App\Mail\ProfileUpdatedEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function admin(): View
    {
        $stats = [
            'revenue' => Order::where('status', 'completed')->sum('total'),
            'orders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            'customers' => User::where('role', User::ROLE_USER)->count(),
            'employees' => User::where('role', User::ROLE_EMPLOYEE)->count(),
            'activeEmployees' => User::where('role', User::ROLE_EMPLOYEE)->where('status', User::STATUS_ACTIVE)->count(),
            'products' => AdminProduct::count(),
            'outOfStock' => AdminProduct::where('quantity', '<=', 0)->count(),
        ];


        /*
        |----------------------------------------------------------------------
        | Inventory Alert — list the exact products that need restocking so
        | the alert is actionable instead of just showing counts.
        |----------------------------------------------------------------------
        */

        $inventoryAlert = AdminProduct::query()
            ->where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->get();

        $stats['lowStock'] = $inventoryAlert->where('quantity', '>', 0)->count();
        $stats['outOfStock'] = $inventoryAlert->where('quantity', '<=', 0)->count();

        $recentOrders = Order::query()
            ->with('user')
            ->latest('placed_at')
            ->limit(5)
            ->get()
            ->map(fn (Order $order): array => [
                'key' => $order->id,
                'id' => $order->order_number,
                'customer' => $order->user->name ?? 'Guest',
                'date' => $order->placed_at?->format('M d, Y')
                    ?? $order->created_at->format('M d, Y'),
                'total' => number_format((float) $order->total, 2),
                'status' => ucfirst($order->status),
            ]);

        $recentEmployees = User::query()
            ->where('role', User::ROLE_EMPLOYEE)
            ->latest()
            ->limit(5)
            ->get();

        // Recent vendor/admin activity.
        $recentActivity = ActivityLog::with('actor')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.index', compact(
            'stats',
            'recentOrders',
            'recentEmployees',
            'inventoryAlert',
            'recentActivity'
        ));
    }

    public function show_orders(): View
    {
        return view(
            'admin.show-orders',
            [
                'orders' => Order::with('user')
                    ->latest()
                    ->get(),
            ]
        );
    }

    public function order_details(?int $id = null): View
    {
        return view(
            'admin.order-details',
            [
                'order' => $id
                    ? Order::with([
                        'user',
                        'items',
                    ])->findOrFail($id)
                    : null,
            ]
        );
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['nullable', 'string', 'in:user,employee'],
        ]);

        $role = $validated['role'] ?? User::ROLE_EMPLOYEE;
        $plainPassword = $validated['password'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
            'role' => $role,
            'status' => User::STATUS_ACTIVE,
        ]);

        $user->markEmailAsVerified();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf('Admin %s created new %s "%s" (%s).', $request->user()->name, $role, $user->name, $user->email),
            $user
        );

        if ($role === User::ROLE_EMPLOYEE) {
            session()->flash('new_credentials', [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $plainPassword,
                'login_url' => route('login'),
                'type' => 'created',
            ]);
            return redirect()->route('admin.employees.index')->with('success', 'Employee account created successfully! You can copy the login credentials below.');
        }

        return back()->with('success', 'User account created successfully!');
    }

    public function users(): View
    {
        $users = User::query()
            ->where('role', User::ROLE_USER)
            ->latest()
            ->get();

        $stats = [
            'total' => $users->count(),

            'active' => $users
                ->where('status', User::STATUS_ACTIVE)
                ->count(),

            'pending' => $users
                ->where('status', User::STATUS_PENDING)
                ->count(),

            'blocked' => $users
                ->whereIn('status', [User::STATUS_SUSPENDED, 'suspend'])
                ->count(),
        ];

        return view(
            'admin.users',
            compact('users', 'stats')
        );
    }

    /**
     * Show an individual customer's activity.
     */
    public function show_user(User $user): View
    {
        abort_unless($user->isUser(), 404);

        $customer = $user;

        $orders = $customer->customerOrders()
            ->with([
                'items.product.images',
            ])
            ->latest('placed_at')
            ->get();

        $validOrders = $orders->where('status', '!=', 'cancelled');

        $stats = [
            'totalOrders' => $orders->count(),

            'totalSpent' => $validOrders->sum('total'),

            'pendingOrders' => $orders
                ->where('status', 'pending')
                ->count(),

            'deliveredOrders' => $orders
                ->where('status', 'delivered')
                ->count(),

            'cancelledOrders' => $orders
                ->where('status', 'cancelled')
                ->count(),

            'avgOrderValue' => $validOrders->count() > 0
                ? $validOrders->avg('total')
                : 0,
        ];

        return view(
            'admin.show-user',
            compact(
                'customer',
                'orders',
                'stats'
            )
        );
    }

    public function profile(Request $request): View
    {
        return view(
            'admin.profile',
            [
                'user' => $request->user()->load('adminDetail'),
            ]
        );
    }

    /**
     * Update the authenticated admin's profile information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'easypaisa_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'easypaisa_account_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jazzcash_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'jazzcash_account_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'account_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'account_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'iban' => [
                'nullable',
                'string',
                'max:255',
            ],

            'stripe_account_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                'current_password',
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Details
        |--------------------------------------------------------------------------
        */

        $detailData = collect($validated)
            ->only([
                'country',
                'state',
                'city',
                'postal_code',
                'address',
                'easypaisa_number',
                'easypaisa_account_title',
                'jazzcash_number',
                'jazzcash_account_title',
                'bank_name',
                'account_title',
                'account_number',
                'iban',
                'stripe_account_id',
            ])
            ->filter(
                fn ($value): bool => $value !== null
            )
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            if (
                $user->adminDetail
                && $user->adminDetail->image
            ) {
                Storage::disk('public')->delete(
                    $user->adminDetail->image
                );
            }

            $path = $request
                ->file('image')
                ->store('admins', 'public');

            $detailData['image'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {
            if (
                $user->adminDetail
                && $user->adminDetail->logo
            ) {
                Storage::disk('public')->delete(
                    $user->adminDetail->logo
                );
            }

            $detailData['logo'] = $request
                ->file('logo')
                ->store('admin-logos', 'public');
        }

        if ($detailData !== []) {
            $user->adminDetail()->updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                $detailData
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

                if (!empty($validated['password'])) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            ]);
        }

        // Send profile updated notification email
        try {
            Mail::to($user->email)->send(new ProfileUpdatedEmail($user, 'admin'));
        } catch (\Exception $e) {
            // Silently fail - don't block profile update if email fails
        }

        return to_route('admin.profile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }

    public function updateUserStatus(
        Request $request,
        User $user
    ): RedirectResponse {
        abort_unless($user->isUser(), 404);

        $validated = $request->validate([
            'status' => [
                'required',
                'in:active,pending,suspend',
            ],
        ]);

        $wasBlocked = $user->status === 'suspend';

        $user->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'active') {
            ActivityLog::record(
                $request->user()->id,
                'admin',
                ActivityLog::ACTION_USER_APPROVED,
                sprintf(
                    'Admin %s approved customer “%s”%s.',
                    $request->user()->name,
                    $user->name,
                    $wasBlocked ? ' (previously blocked)' : '',
                ),
                $user,
                ['status' => 'active'],
            );
        } elseif ($validated['status'] === 'suspend') {
            ActivityLog::record(
                $request->user()->id,
                'admin',
                ActivityLog::ACTION_USER_BLOCKED,
                sprintf(
                    'Admin %s blocked customer “%s” (%s).',
                    $request->user()->name,
                    $user->name,
                    $user->email,
                ),
                $user,
                ['status' => 'suspend'],
            );
        }

        return to_route('admin.users.index')
            ->with(
                'success',
                $validated['status'] === 'active'
                    ? 'User approved successfully.'
                    : 'User status updated successfully.'
            );
    }

    public function updateOrderStatus(
        Request $request,
        Order $order
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,processing,shipped,delivered,cancelled',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        /*
        |----------------------------------------------------------------------
        | Notify the customer when their order ships or is delivered.
        |----------------------------------------------------------------------
        */
        if ($order->user && $validated['status'] === 'shipped') {
            Mail::to($order->user->email)
                ->send(new OrderShippedEmail($order->load('items')));
        } elseif ($order->user && $validated['status'] === 'delivered') {
            Mail::to($order->user->email)
                ->send(new OrderDeliveredEmail($order->load('items')));
        }

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_STATUS,
            sprintf(
                'Admin %s changed order %s status to %s.',
                $request->user()->name,
                $order->order_number,
                $validated['status'],
            ),
            $order,
            [
                'status' => $validated['status'],
            ],
        );

        return to_route('admin.orders.index')
            ->with(
                'success',
                'Order status updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete / Reactivate (suspended accounts & cancelled orders)
    |--------------------------------------------------------------------------
    */

    /**
     * Soft-delete a blocked customer — moves the account to the Recycle Bin.
     */
    public function deleteCustomer(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isUser(), 404);
        abort_if(in_array($user->status, ['active', 'pending'], true), 403, 'Only blocked customers can be deleted. Block the customer first.');

        $user->update(['deleted_by' => $request->user()->id]);
        $user->delete();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_DELETED,
            sprintf(
                'Admin %s deleted blocked customer “%s” (%s). It can be restored from the Recycle Bin.',
                $request->user()->name,
                $user->name,
                $user->email,
            ),
            $user,
        );

        return to_route('admin.users.index')
            ->with('success', 'Blocked customer deleted. You can restore or permanently delete the account from the Recycle Bin.');
    }

    /**
     * Reactivate a suspended vendor/customer straight from the Recycle Bin
     * without soft-deleting it first.
     */
    public function reactivateAccount(Request $request, int $id): RedirectResponse
    {
        $user = User::query()
            ->where('role', '!=', User::ROLE_ADMIN)
            ->whereIn('status', ['suspend', 'suspended'])
            ->findOrFail($id);

        $user->update(['status' => User::STATUS_ACTIVE]);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf(
                'Admin %s re-activated customer “%s” from the Recycle Bin.',
                $request->user()->name,
                $user->name,
            ),
            $user,
            ['status' => 'active'],
        );

        return to_route('admin.recycle-bin')
            ->with('success', 'Customer re-activated successfully.');
    }

    /**
     * Soft-delete a cancelled order — moves it to the Recycle Bin.
     */
    public function deleteCancelledOrder(Request $request, int $id): RedirectResponse
    {
        $order = Order::query()
            ->where('status', 'cancelled')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        $order->update(['deleted_by' => $request->user()->id]);
        $order->delete();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_DELETED,
            sprintf(
                'Admin %s deleted cancelled order %s ($%s). It can be restored from the Recycle Bin.',
                $request->user()->name,
                $order->order_number,
                number_format((float) $order->total, 2),
            ),
            $order,
        );

        return to_route('admin.orders.index')
            ->with('success', 'Cancelled order deleted. You can restore or permanently delete it from the Recycle Bin.');
    }

    /**
     * Put a cancelled order back into processing from the Recycle Bin.
     */
    public function restoreCancelledOrder(Request $request, int $id): RedirectResponse
    {
        $order = Order::query()
            ->where('status', 'cancelled')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        $order->update(['status' => 'processing']);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_STATUS,
            sprintf(
                'Admin %s re-activated cancelled order %s from the Recycle Bin (back to processing).',
                $request->user()->name,
                $order->order_number,
            ),
            $order,
            ['status' => 'processing'],
        );

        return to_route('admin.recycle-bin')
            ->with('success', 'Order re-activated (set to processing).');
    }

    /*
    |--------------------------------------------------------------------------
    | Recycle Bin
    |--------------------------------------------------------------------------
    */

    public function recycleBin(): View
    {
        $orders = Order::onlyTrashed()
            ->with([
                'user',
                'deletedBy',
            ])
            ->latest('deleted_at')
            ->get();

        $users = User::onlyTrashed()
            ->with('deletedBy')
            ->where(
                'role',
                '!=',
                User::ROLE_ADMIN
            )
            ->latest('deleted_at')
            ->get();

        $vendorActions = $orders->whereNotNull('deleted_by')->where('deleted_by', '!=', auth()->id())->count()
            + $users->whereNotNull('deleted_by')->where('deleted_by', '!=', auth()->id())->count();

        return view('admin.recycle-bin', compact('orders', 'users', 'vendorActions'));
    }

    public function restoreOrder(
        Request $request,
        int $id
    ): RedirectResponse {
        $order = Order::onlyTrashed()->findOrFail($id);

        $order->restore();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_RESTORED,
            sprintf(
                'Admin %s restored order %s from the Recycle Bin.',
                $request->user()->name,
                $order->order_number
            ),
            $order
        );

        return to_route('admin.recycle-bin')
            ->with(
                'success',
                'Order restored successfully.'
            );
    }

    public function forceDeleteOrder(
        Request $request,
        int $id
    ): RedirectResponse {
        $order = Order::onlyTrashed()->findOrFail($id);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_PURGED,
            sprintf(
                'Admin %s permanently deleted order %s.',
                $request->user()->name,
                $order->order_number
            ),
            $order
        );

        $order->forceDelete();

        return to_route('admin.recycle-bin')
            ->with(
                'success',
                'Order permanently deleted.'
            );
    }

    public function restoreUser(
        Request $request,
        int $id
    ): RedirectResponse {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_RESTORED,
            sprintf(
                'Admin %s restored account “%s” from the Recycle Bin.',
                $request->user()->name,
                $user->name
            ),
            $user
        );

        return to_route('admin.recycle-bin')
            ->with(
                'success',
                'Account restored successfully.'
            );
    }

    public function forceDeleteUser(
        Request $request,
        int $id
    ): RedirectResponse {
        $user = User::onlyTrashed()->findOrFail($id);

        abort_if(
            $user->id === $request->user()->id,
            403
        );

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_PURGED,
            sprintf(
                'Admin %s permanently deleted account “%s” (%s).',
                $request->user()->name,
                $user->name,
                $user->email
            ),
            $user
        );

        $user->forceDelete();

        return to_route('admin.recycle-bin')
            ->with(
                'success',
                'Account permanently deleted.'
            );
    }




    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    public function activity(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with([
                'actor',
                'subject',
            ])
            ->when(
                $request->filled('actor'),
                fn (Builder $query): Builder => $query->where(
                    'actor_role',
                    $request->string('actor')
                )
            )
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $stats = [
            'total' => ActivityLog::count(),

            'admin' => ActivityLog::where(
                'actor_role',
                'admin'
            )->count(),

            'employee' => ActivityLog::where(
                'actor_role',
                'employee'
            )->count(),

            'vendor' => ActivityLog::where(
                'actor_role',
                'vendor'
            )->count(),

            'today' => ActivityLog::whereDate(
                'created_at',
                today()
            )->count(),
        ];

        return view(
            'admin.activity',
            compact(
                'logs',
                'stats'
            )
        );
    }

    public function deleteActivityLog(Request $request, int $id): RedirectResponse
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return to_route('admin.activity')->with('success', 'Activity log entry deleted.');
    }

    public function questions(Request $request): View
    {
        $questions = ProductQuestion::with(['user', 'product'])
            ->latest()
            ->paginate(20);

        return view('admin.questions', compact('questions'));
    }

    public function answerQuestion(Request $request, ProductQuestion $question): RedirectResponse
    {
        $validated = $request->validate([
            'answer' => ['required', 'string', 'max:2000'],
        ]);

        $question->update([
            'answer' => $validated['answer'],
            'answered_at' => now(),
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Answer submitted successfully.');
    }

    /**
     * Delete a product question.
     */
    public function destroyQuestion(ProductQuestion $question): RedirectResponse
    {
        $question->delete();

        return back()->with('success', 'Question deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | New Client Requirements
    |--------------------------------------------------------------------------
    */

    public function createExcel(): View
    {
        return view('admin.excel.create');
    }

    public function generateExcel(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'order_status' => 'nullable|string'
        ]);

        $query = \App\Models\Order::query()
            ->with(['user', 'items'])
            ->where(function($q) use ($request) {
                $q->whereBetween('placed_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ])->orWhereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            });

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
            'orders-' . $request->from_date . '-to-' . $request->to_date . '.xlsx',
            'Filtered Orders'
        );
    }

    public function blacklistedPaypal(): View
    {
        return view('admin.paypal.index');
    }

    public function reservations(): View
    {
        $reservations = \App\Models\Reservation::with(['user', 'product'])->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function createReservation(): View
    {
        return view('admin.reservations.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Employee Management (Admin)
    |--------------------------------------------------------------------------
    */

    /**
     * Display all employees with filters and stats.
     */
    public function employees(Request $request): View
    {
        $query = User::query()
            ->where('role', User::ROLE_EMPLOYEE)
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $normalizedStatus = ($request->status === 'suspend') ? User::STATUS_SUSPENDED : $request->status;
            $query->where('status', $normalizedStatus);
        }

        $allEmployees = User::where('role', User::ROLE_EMPLOYEE)->get();
        $stats = [
            'total' => $allEmployees->count(),
            'active' => $allEmployees->where('status', User::STATUS_ACTIVE)->count(),
            'pending' => $allEmployees->where('status', User::STATUS_PENDING)->count(),
            'suspended' => $allEmployees->whereIn('status', [User::STATUS_SUSPENDED, 'suspend'])->count(),
        ];

        $employees = $query->paginate(15)->withQueryString();

        return view('admin.employees.index', compact('employees', 'stats'));
    }

    /**
     * Store new employee account and prepare credentials for sharing.
     */
    public function storeEmployee(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['nullable', 'string', 'in:active,pending,suspended'],
        ]);

        $plainPassword = $validated['password'];

        $employee = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
            'role' => User::ROLE_EMPLOYEE,
            'status' => $validated['status'] ?? User::STATUS_ACTIVE,
        ]);

        // Automatically mark email as verified so employee can log in immediately
        $employee->markEmailAsVerified();

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf('Admin %s created new employee "%s" (%s).', $request->user()->name, $employee->name, $employee->email),
            $employee
        );

        // Flash credentials so Admin can easily copy and give to the Employee
        session()->flash('new_credentials', [
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => $plainPassword,
            'phone' => $employee->phone,
            'login_url' => route('login'),
            'type' => 'created',
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee account created successfully! You can copy the login credentials below.');
    }

    /**
     * Update employee status (active / suspended).
     */
    public function updateEmployeeStatus(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isEmployee(), 404);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:active,pending,suspended,suspend'],
        ]);

        $normalizedStatus = ($validated['status'] === 'suspend') ? User::STATUS_SUSPENDED : $validated['status'];
        $user->update(['status' => $normalizedStatus]);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf('Admin %s updated status of employee "%s" to %s.', $request->user()->name, $user->name, $normalizedStatus),
            $user
        );

        return back()->with('success', "Employee {$user->name} status updated to {$normalizedStatus}.");
    }

    /**
     * Reset employee password and generate credentials to give to the employee.
     */
    public function resetEmployeePassword(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isEmployee(), 404);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $plainPassword = $validated['password'];
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
        ]);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf('Admin %s reset password for employee "%s" (%s).', $request->user()->name, $user->name, $user->email),
            $user
        );

        session()->flash('new_credentials', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $plainPassword,
            'phone' => $user->phone,
            'login_url' => route('login'),
            'type' => 'reset',
        ]);

        return back()->with('success', "Password for {$user->name} has been updated! You can copy the new credentials below.");
    }

    /**
     * Delete an employee.
     */
    public function deleteEmployee(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isEmployee(), 404);

        $name = $user->name;
        $email = $user->email;

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_USER_DELETED,
            sprintf('Admin %s deleted employee "%s" (%s).', $request->user()->name, $name, $email)
        );

        $user->delete();

        return redirect()->route('admin.employees.index')->with('success', "Employee {$name} deleted successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Change Password
    |--------------------------------------------------------------------------
    */

    public function changePassword(): View
    {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided current password does not match your account.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        ActivityLog::record(
            $user->id,
            'admin',
            ActivityLog::ACTION_USER_APPROVED,
            sprintf('Admin %s changed their login password.', $user->name),
            $user
        );

        return back()->with('success', 'Your password has been changed successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Support
    |--------------------------------------------------------------------------
    */

    public function support(): View
    {
        return view('admin.support');
    }

    public function sendSupport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'string', 'in:low,normal,high,urgent'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            'support_request',
            sprintf('Admin %s submitted a support request: [%s] %s', $request->user()->name, strtoupper($validated['priority']), $validated['subject']),
            $request->user(),
            $validated
        );

        return back()->with('success', 'Your support request has been submitted successfully! The technical support team will review it shortly.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Delay Refunds
    |--------------------------------------------------------------------------
    */

    public function delayRefunds(Request $request): View
    {
        $query = Order::query()
            ->with(['items.product', 'user']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['on_hold', 'refunded_pending_review', 'review_submitted_refund', 'refunded', 'cancelled']);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $allRefundOrders = Order::whereIn('status', ['on_hold', 'refunded_pending_review', 'review_submitted_refund', 'refunded', 'cancelled'])->get();

        $stats = [
            'total' => $allRefundOrders->count(),
            'on_hold' => $allRefundOrders->where('status', 'on_hold')->count(),
            'pending_review' => $allRefundOrders->whereIn('status', ['refunded_pending_review', 'review_submitted_refund'])->count(),
            'refunded' => $allRefundOrders->where('status', 'refunded')->count(),
            'total_amount' => $allRefundOrders->sum('total'),
        ];

        $delayedOrders = $query->latest('placed_at')->latest('id')->paginate(15)->withQueryString();

        return view('admin.delay-refunds', compact('delayedOrders', 'stats'));
    }

    public function updateRefundStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:refunded,on_hold,processing,cancelled,refunded_pending_review,delivered'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $oldStatus = $order->status;
        $order->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ? ($order->notes ? $order->notes . "\n" . $validated['notes'] : $validated['notes']) : $order->notes,
        ]);

        ActivityLog::record(
            $request->user()->id,
            'admin',
            ActivityLog::ACTION_ORDER_STATUS,
            sprintf('Admin %s updated order #%s refund status from %s to %s.', $request->user()->name, $order->order_number, $oldStatus, $validated['status']),
            $order,
            ['old_status' => $oldStatus, 'new_status' => $validated['status']]
        );

        return back()->with('success', "Order #{$order->order_number} status updated to " . str_replace('_', ' ', $validated['status']) . " successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | Admins / Management Team Directory
    |--------------------------------------------------------------------------
    */

    public function admins(): View
    {
        $systemAdmins = User::query()
            ->where('role', User::ROLE_ADMIN)
            ->latest()
            ->get();

        $managementTeam = [
            ['id' => 1, 'name' => 'Osama Ahmed', 'role' => 'Refund Manager', 'department' => 'Disputes & Refunds', 'whatsapp' => '923001234567', 'email' => 'osama@ecommerce.com'],
            ['id' => 2, 'name' => 'Refund Admin', 'role' => 'PayPal Change & Order Verification Manager', 'department' => 'Payment Verification', 'whatsapp' => '923007654321', 'email' => 'refunds@ecommerce.com'],
            ['id' => 3, 'name' => 'Dispute Manager', 'role' => 'Dispute & Less Refunds Manager', 'department' => 'Disputes & Settlements', 'whatsapp' => '923112233445', 'email' => 'disputes@ecommerce.com'],
            ['id' => 4, 'name' => 'Sajid Arif', 'role' => 'PM Recruitment & Commission Issue Manager', 'department' => 'HR & Commission', 'whatsapp' => '923223344556', 'email' => 'sajid@ecommerce.com'],
            ['id' => 5, 'name' => 'Muhammad Ubaid', 'role' => 'Scam & Neg Issues Resolution Manager', 'department' => 'Fraud Detection & Compliance', 'whatsapp' => '923445566778', 'email' => 'ubaid@ecommerce.com'],
            ['id' => 6, 'name' => 'Muhammad Majid', 'role' => 'Wrong On-Hold / Cancelled Orders Manager', 'department' => 'Order Management', 'whatsapp' => null, 'email' => 'majid@ecommerce.com'],
            ['id' => 7, 'name' => 'Main Admin', 'role' => 'Head Administrator & Operations Director', 'department' => 'Executive Office', 'whatsapp' => '923000000000', 'email' => 'mainadmin@ecommerce.com'],
        ];

        $stats = [
            'total_admins' => $systemAdmins->count(),
            'total_managers' => count($managementTeam),
            'active_departments' => 6,
        ];

        return view('admin.admins', compact('systemAdmins', 'managementTeam', 'stats'));
    }
}
