<?php

namespace App\Http\Controllers;

use App\Mail\ProfileUpdatedEmail;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\UserPaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function user(Request $request): View
    {
        $user = $request->user();

        $reservations = \App\Models\Reservation::where('user_id', $user->id)->with('product')->latest()->limit(5)->get();

        $stats = [
            'totalOrders' => \App\Models\Reservation::where('user_id', $user->id)->count(),
            'totalSpent' => \App\Models\Reservation::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pendingOrders' => \App\Models\Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'deliveredOrders' => \App\Models\Reservation::where('user_id', $user->id)->where('status', 'completed')->count(),
            'wishlistCount' => 0, // Removed wishlist feature
        ];

        $userMessage = \App\Models\UserMessage::where('is_active', true)->first();

        return view('user.index', compact('user', 'reservations', 'stats', 'userMessage'));
    }

    public function history(Request $request): View
    {
        return view('user.order-history', ['orders' => $request->user()->customerOrders()->latest()->get()]);
    }

    public function viewDetail(Request $request, ?int $id = null): View
    {
        $order = $id ? $request->user()->customerOrders()->with('items')->findOrFail($id) : null;

        return view('user.view-detail', compact('order'));
    }

    public function settings(Request $request): View
    {
        $user = $request->user();

        $paymentMethods = $user->paymentMethods()->orderByDesc('is_default')->orderByDesc('created_at')->get();

        $removedMethods = $user->paymentMethods()->onlyTrashed()->orderByDesc('deleted_at')->limit(5)->get();

        $shippingAddresses = $user->shippingAddresses()->latest()->get();

        return view('user.settings', compact('user', 'paymentMethods', 'removedMethods', 'shippingAddresses'));
    }

    /**
     * Save a new payment method for the authenticated customer.
     */
    public function storePaymentMethod(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:easypaisa,jazzcash,bank'],
            'account_title' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'bank_name' => ['nullable', 'required_if:type,bank', 'string', 'max:255'],
            'iban' => ['nullable', 'string', 'max:34'],
        ]);

        $request->user()->paymentMethods()->create($validated);

        return to_route('user.settings')
            ->with('success', ucfirst($validated['type'] === 'bank' ? 'bank account' : $validated['type']).' saved successfully.');
    }

    /**
     * Soft-delete a saved payment method — it disappears from the customer's
     * dashboard but the row is kept in the database.
     */
    public function deletePaymentMethod(Request $request, UserPaymentMethod $paymentMethod): RedirectResponse
    {
        abort_unless($paymentMethod->user_id === $request->user()->id, 404);

        $paymentMethod->delete();

        return to_route('user.settings')->with('success', 'Payment method removed.');
    }

    /**
     * Restore a soft-deleted payment method.
     */
    public function restorePaymentMethod(Request $request, int $id): RedirectResponse
    {
        $paymentMethod = $request->user()->paymentMethods()->onlyTrashed()->findOrFail($id);
        $paymentMethod->restore();

        return to_route('user.settings')->with('success', 'Payment method restored.');
    }

    /**
     * Save a new shipping address for the authenticated customer.
     */
    public function storeShippingAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'landmark' => ['nullable', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $isDefault = (bool) ($validated['is_default'] ?? false);

        if ($isDefault) {
            $request->user()->shippingAddresses()->update(['is_default' => false]);
        }

        $request->user()->shippingAddresses()->create($validated + ['is_default' => $isDefault]);

        return to_route('user.settings')->with('success', 'Shipping address saved.');
    }

    /**
     * Soft-delete a saved shipping address.
     */
    public function deleteShippingAddress(Request $request, ShippingAddress $shippingAddress): RedirectResponse
    {
        abort_unless($shippingAddress->user_id === $request->user()->id, 404);

        $shippingAddress->delete();

        return to_route('user.settings')->with('success', 'Shipping address removed.');
    }

    /**
     * Set a shipping address as the customer's default.
     */
    public function setDefaultShippingAddress(Request $request, ShippingAddress $shippingAddress): RedirectResponse
    {
        abort_unless($shippingAddress->user_id === $request->user()->id, 404);

        $request->user()->shippingAddresses()->update(['is_default' => false]);
        $shippingAddress->update(['is_default' => true]);

        return to_route('user.settings')->with('success', 'Default shipping address updated.');
    }

    /**
      * Update the authenticated user's profile information.
      */
    public function updateSettings(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'landmark' => ['nullable', 'string', 'max:100'],
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $validated['image'] = $request->file('image')->store('avatars', 'public');
        }

        $user->update($validated);

        $detailData = collect($validated)->only(['city', 'address', 'country', 'state', 'postal_code', 'landmark'])->filter()->all();

        if ($detailData !== []) {
            $user->userDetail()->updateOrCreate(
                ['user_id' => $user->id],
                $detailData
            );
        }

        // Send profile updated notification email
        try {
            Mail::to($user->email)->send(new ProfileUpdatedEmail($user, 'user'));
        } catch (\Exception $e) {
            // Silently fail - don't block profile update if email fails
        }

        return to_route('user.settings')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Reserve a product
     */
    public function reserve(Request $request, \App\Models\AdminProduct $product): RedirectResponse
    {
        \App\Models\Reservation::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Product reserved successfully! Check your dashboard for updates.');
    }
}