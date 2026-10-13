<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedAdminEmail;
use App\Mail\OrderPlacedCustomerEmail;
use App\Mail\OrderPlacedVendorEmail;
use App\Models\AdminDetail;
use App\Models\AdminProduct;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use App\Models\VendorDetail;
use App\Services\CouponService;
use App\Services\Stripe;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     */
    public function order(Request $request, string $slug): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Get Cart
        |--------------------------------------------------------------------------
        */
        $cart = $this->cartQuantities($request);

        /*
        |--------------------------------------------------------------------------
        | Empty Cart
        |--------------------------------------------------------------------------
        */
        if ($cart === []) {
            return to_route('cart.list', 'products')
                ->with('warning', 'Your cart is empty.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Available Products
        |--------------------------------------------------------------------------
        */
        $products = AdminProduct::with([
                'images',
                ])
            ->whereIn('id', array_keys($cart))
            ->where('status', 'published')
            ->where('stock_status', 'in_stock')
            ->where('quantity', '>', 0)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Make Sure All Cart Products Are Available
        |--------------------------------------------------------------------------
        */
        if ($products->count() !== count($cart)) {
            return to_route('cart.list', 'products')
                ->with(
                    'warning',
                    'One or more cart items are no longer available.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Payment Details
        |--------------------------------------------------------------------------
        */
        $adminDetails = AdminDetail::query()
            ->with('user')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Payment Methods (dynamic from admin/vendor DB)
        |--------------------------------------------------------------------------
        */
        $paymentMethods = [];

        if ($adminDetails) {
            if ($adminDetails->easypaisa_number) {
                $paymentMethods['easypaisa'] = [
                    'label' => 'Easypaisa',
                    'account_title' => $adminDetails->easypaisa_account_title ?? $adminDetails->bank_name,
                    'number' => $adminDetails->easypaisa_number,
                    'type' => 'easypaisa',
                ];
            }
            if ($adminDetails->jazzcash_number) {
                $paymentMethods['jazzcash'] = [
                    'label' => 'JazzCash',
                    'account_title' => $adminDetails->jazzcash_account_title ?? null,
                    'number' => $adminDetails->jazzcash_number,
                    'type' => 'jazzcash',
                ];
            }
            if ($adminDetails->bank_name && $adminDetails->account_number) {
                $paymentMethods['btransfer'] = [
                    'label' => 'Bank Transfer',
                    'bank_name' => $adminDetails->bank_name,
                    'account_title' => $adminDetails->account_title,
                    'account_number' => $adminDetails->account_number,
                    'iban' => $adminDetails->iban,
                    'type' => 'bank',
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Subtotal
        |--------------------------------------------------------------------------
        */
        $subtotal = $products->sum(
            fn (AdminProduct $product): float =>
                (float) (
                    $product->sale_price
                    ?? $product->regular_price
                ) * (int) $cart[$product->id]
        );

        /*
        |--------------------------------------------------------------------------
        | Coupon
        |--------------------------------------------------------------------------
        */
        $couponService = app(CouponService::class);
        $coupon = $couponService->activeCoupon($request);
        $discount = $couponService->discountFor($request, $products->map(fn (AdminProduct $product): array => [
            'product' => $product,
            'subtotal' => (float) ($product->sale_price ?? $product->regular_price) * (int) $cart[$product->id],
        ])->values(), $request->user());

        /*
        |--------------------------------------------------------------------------
        | Checkout View
        |--------------------------------------------------------------------------
        */
        return view('checkout', [
            'slug' => $slug,
            'cart' => $cart,
            'items' => $products,
            'adminDetails' => $adminDetails,
            'paymentMethods' => $paymentMethods,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'coupon' => $coupon,
            'checkoutUser' => $request->user(),
        ]);
    }

/**
     * Place order for "manual" payment methods (COD, bank transfer, Easypaisa
     * and JazzCash). When the customer selects "card" we hand off to the
     * Stripe hosted checkout instead.
     */
    public function place(Request $request, string $slug): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Checkout Form
        |--------------------------------------------------------------------------
        */
        $validated = $this->validateCheckout($request);

        /*
        |--------------------------------------------------------------------------
        | Rebuild Cart
        |--------------------------------------------------------------------------
        */
        $cart = $this->cartQuantities($request);

        if ($cart === []) {
            return to_route('cart.list', 'products')
                ->with('warning', 'Your cart is empty.');
        }

        /*
        |--------------------------------------------------------------------------
        | Card payments go through the Stripe checkout flow
        |--------------------------------------------------------------------------
        */
        if ($validated['payment_method'] === 'card') {
            return $this->startStripeCheckout($request, $slug, $validated, $cart);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Order Inside Database Transaction
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($request, $validated, $cart): void {
            $this->createOrder($request, $validated, $cart, null);
        });

        $this->clearCart($request);

        if ($request->user()) {
            return to_route('user.orders.history')
                ->with(
                    'success',
                    'Thank you for your order. We have received your order and will ship it to you very soon.'
                );
        }

        return to_route('home')
            ->with(
                'success',
                'Thank you for your order. We have received your order and will ship it to you very soon.'
            );
    }

    /**
     * Build a Stripe hosted Checkout Session and redirect the customer to it.
     */
    public function startStripeCheckout(
        Request $request,
        string $slug,
        array $validated,
        array $cart
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Load The Products Being Purchased
        |--------------------------------------------------------------------------
        */
        $products = AdminProduct::query()
            ->whereIn('id', array_keys($cart))
            ->where('status', 'published')
            ->where('stock_status', 'in_stock')
            ->where('quantity', '>', 0)
            ->get();

        if ($products->count() !== count($cart)) {
            return to_route('cart.list', 'products')
                ->with('warning', 'One or more cart items are no longer available.');
        }
/*
        |--------------------------------------------------------------------------
        | Calculate The Total For The Stripe Session
        |--------------------------------------------------------------------------
        */
        $subtotal = $products->sum(
            fn (AdminProduct $product): float =>
                (float) ($product->sale_price ?? $product->regular_price)
                * (int) $cart[$product->id]
        );

        $shipping = $validated['shipping'] === 'express' ? 20 : 10;
        $total = $subtotal + $shipping;
        $amount = (int) round($total * 100);

        /*
        |--------------------------------------------------------------------------
        | Resolve The Destination STRIPE Connected Account
        |--------------------------------------------------------------------------
        |
        | If every item belongs to a single seller AND that seller has
        | configured a Stripe Connected account, the payment is settled
        | directly to their account. Otherwise the platform (ShopHub)
        | receives the money and settles it manually.
        |
        */
        $destination = AdminDetail::query()
            ->value('stripe_account_id');

        $stripe = new Stripe;

        if (! $stripe->configured()) {
            return to_route('checkout.form', $slug)
                ->with('error', 'Card payments are unavailable right now. Please use another payment method.');
        }

        $payload = [
            'mode' => 'payment',
            'customer_email' => $validated['email'],
            'client_reference_id' => (string) ($request->user()?->id ?? 'guest-' . $validated['email']),
            'success_url' => rtrim(route('checkout.stripe.success', $slug), '/')
                . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.stripe.cancel', $slug),
            'line_items[0][quantity]' => '1',
            'line_items[0][price_data][currency]' => config('stripe.currency'),
            'line_items[0][price_data][unit_amount]' => $amount,
            'line_items[0][price_data][product_data][name]' => 'ShopHub order total',
            'metadata[slug]' => $slug,
        ];

        if ($destination) {
            $payload['payment_intent_data[transfer_data][destination]'] = $destination;
        }

        try {
            $session = $stripe->createCheckoutSession($payload);
        } catch (ConnectionException) {
            return back()->withInput()
                ->with('error', 'We could not reach the payment provider. Please try again.');
        }

        if (empty($session['url'])) {
            return back()->withInput()
                ->with('error', 'The payment could not be completed. Please try another method.');
        }

        session([
            'stripe_pending_'.$session['id'] => [
                'cart' => $cart,
                'validated' => $validated,
                'slug' => $slug,
                'amount' => $total,
            ],
        ]);

        return redirect()->away($session['url']);
    }

/**
     * Stripe success callback - the order is created only once Stripe has
     * confirmed the payment as paid.
     */
    public function stripeSuccess(Request $request, string $slug): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return to_route('checkout.form', $slug)
                ->with('error', 'No payment session was found.');
        }

        $pending = session('stripe_pending_'.$sessionId);

        if (! $pending) {
            return to_route('checkout.form', $slug)
                ->with('error', 'This payment session is no longer available.');
        }

        $stripe = new Stripe;

        try {
            $session = $stripe->retrieveCheckoutSession($sessionId);
        } catch (\RuntimeException) {
            return to_route('checkout.form', $slug)
                ->with('error', 'We could not verify your payment. Please contact support or try again.');
        }

        if (($session['payment_status'] ?? null) !== 'paid') {
            return to_route('checkout.form', $slug)
                ->with('error', 'Your payment has not been confirmed yet. Please try again.');
        }

        DB::transaction(function () use ($request, $pending, $sessionId): void {
            $this->createOrder(
                $request,
                $pending['validated'],
                $pending['cart'],
                $sessionId
            );
        });

        $this->clearCart($request);
        session()->forget('stripe_pending_'.$sessionId);

        if ($request->user()) {
            return to_route('user.orders.history')
                ->with('success', 'Thank you for your order. We have received your order and will ship it to you very soon.');
        }

        return to_route('home')
            ->with('success', 'Thank you for your order. We have received your order and will ship it to you very soon.');
    }

    /**
     * Stripe cancel callback - the customer aborted the payment.
     */
    public function stripeCancel(string $slug): RedirectResponse
    {
        return to_route('checkout.form', $slug)
            ->with('error', 'Payment was cancelled. No charge has been made.');
    }
/**
     * Validate the shared checkout form fields.
     */
    private function validateCheckout(Request $request): array
    {
        $allowedPayments = ['cod', 'card'];

        $adminDetails = AdminDetail::query()->first();
        if ($adminDetails?->easypaisa_number) {
            $allowedPayments[] = 'easypaisa';
        }
        if ($adminDetails?->jazzcash_number) {
            $allowedPayments[] = 'jazzcash';
        }
        if ($adminDetails?->bank_name && $adminDetails?->account_number) {
            $allowedPayments[] = 'btransfer';
        }


        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:1000'],
            'shipping' => ['required', 'in:standard,express'],
            'payment_method' => ['required', 'in:' . implode(',', $allowedPayments)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    /**
     * Load the current cart as a product_id => quantity map (from session,
     * falling back to the logged-in user's database cart).
     */
    private function cartQuantities(Request $request): array
    {
        $cart = collect($request->session()->get('cart', []));

        if ($cart->isEmpty() && $request->user()?->isUser()) {
            $cart = $request->user()->cartItems()->pluck('quantity', 'product_id');
        }

        return $cart
            ->map(fn (mixed $quantity): int => (int) $quantity)
            ->filter(fn (int $quantity): bool => $quantity > 0)
            ->all();
    }

    /**
     * Create the order + items and fire the notification emails.
     * Relies on the surrounding database transaction (if any).
     */
    private function createOrder(
        Request $request,
        array $validated,
        array $cart,
        ?string $paymentReference = null
    ): Order {
        $products = AdminProduct::whereIn('id', array_keys($cart))
            ->lockForUpdate()
            ->get();

        abort_unless(
            $products->count() === count($cart),
            422,
            'A product in your cart is no longer available.'
        );

        $items = [];
        $subtotal = 0.0;

        foreach ($products as $product) {
            $quantity = (int) $cart[$product->id];

            abort_unless(
                $product->status === 'published'
                && $product->stock_status === 'in_stock'
                && $quantity > 0
                && $quantity <= $product->quantity,
                422,
                'A product is no longer available in the requested quantity.'
            );

            $unitPrice = (float) ($product->sale_price ?? $product->regular_price);
            $lineSubtotal = $unitPrice * $quantity;
            $subtotal += $lineSubtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unitPrice' => $unitPrice,
                'lineSubtotal' => $lineSubtotal,
            ];

            $product->decrement('quantity', $quantity);

            if ($product->quantity <= 0) {
                $product->update(['stock_status' => 'out_of_stock']);
            }
        }

        $shipping = $validated['shipping'] === 'express' ? 20 : 10;

        /*
        |--------------------------------------------------------------------------
        | Apply Coupon
        |--------------------------------------------------------------------------
        */
        $couponService = app(CouponService::class);
        $coupon = $couponService->activeCoupon($request);

        $orderItemsForCoupon = collect($items)->map(fn (array $item): array => [
            'product' => $item['product'],
            'subtotal' => $item['lineSubtotal'],
        ])->values()->all();

        $discount = $coupon ? $couponService->discountFor($request, $orderItemsForCoupon, $request->user()) : 0.0;

        $orderUser = $request->user() ?? User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => bcrypt(Str::random(32)),
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
            'login_verified_at' => now(),
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . Str::upper(Str::random(10)),
            'user_id' => $orderUser->id,
            'vendor_id' => null,
            'subtotal' => $subtotal,
            'discount_total' => $discount,
            'shipping_total' => $shipping,
            'shipping_method' => $validated['shipping'],
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $paymentReference,
            'total' => $subtotal - $discount + $shipping,
            'status' => 'pending',
            'shipping_name' => $validated['name'],
            'shipping_phone' => $validated['phone'],
            'shipping_address' => $validated['city'] . ', ' . $validated['address'],
            'notes' => $validated['notes'] ?? null,
            'placed_at' => now(),
            'coupon_code' => $coupon?->code,
        ]);

        if ($coupon) {
            $coupon->increment('times_used');

            // Append to the coupon redemption ledger so usage is auditable
            // and per-customer limits can be enforced later.
            $coupon->usages()->create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'discount_amount' => $discount,
            ]);
        }

        $request->session()->forget('coupon_code');

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unitPrice'],
                'subtotal' => $item['lineSubtotal'],
            ]);
        }

        $order->load(['items.product', 'user']);

        $adminUser = User::query()->where('role', User::ROLE_ADMIN)->first();

        if ($adminUser && $adminUser->email) {
            Mail::to($adminUser->email)->send(new OrderPlacedAdminEmail($order));
        }

        if ($orderUser->email) {
            Mail::to($orderUser->email)
                ->send(new OrderPlacedCustomerEmail($order));
        }

        return $order;
    }

    /**
     * Clear both the session cart and (for logged-in users) the database cart.
     */
    private function clearCart(Request $request): void
    {
        $request->session()->forget('cart');

        if ($request->user()?->isUser()) {
            CartItem::query()->where('user_id', $request->user()->id)->delete();
        }
    }
}
