<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartListController extends Controller
{
    public function list(Request $request, string $slug): View
    {
        $cart = $this->cartFromRequest($request);
        $products = AdminProduct::with('images')
            ->whereIn('id', array_keys($cart))
            ->where('status', 'published')
            ->where('stock_status', 'in_stock')
            ->get();
        $items = $products->map(fn (AdminProduct $product): array => [
            'product' => $product,
            'quantity' => min((int) ($cart[$product->id] ?? 0), $product->quantity),
            'subtotal' => (float) ($product->sale_price ?? $product->regular_price) * min((int) ($cart[$product->id] ?? 0), $product->quantity),
        ])->filter(fn (array $item): bool => $item['quantity'] > 0)->values();

        $subtotal = $items->sum('subtotal');

        $couponService = app(CouponService::class);
        $coupon = $couponService->activeCoupon($request);
        $user = $request->user();
        $discount = $couponService->discountFor($request, $items, $user);

        return view('cart-list', [
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'coupon' => $coupon,
        ]);
    }

    public function applyCoupon(Request $request, string $slug): RedirectResponse
    {
        $code = strtoupper((string) $request->input('code'));

        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->isRedeemable()) {
            return back()->with('warning', 'Invalid or expired coupon code.');
        }

        $cart = $this->cartFromRequest($request);
        $products = AdminProduct::with('images')
            ->whereIn('id', array_keys($cart))
            ->where('status', 'published')
            ->where('stock_status', 'in_stock')
            ->get();

        $items = $products->map(fn (AdminProduct $product): array => [
            'product' => $product,
            'quantity' => min((int) ($cart[$product->id] ?? 0), $product->quantity),
            'subtotal' => (float) ($product->sale_price ?? $product->regular_price) * min((int) ($cart[$product->id] ?? 0), $product->quantity),
        ])->filter(fn (array $item): bool => $item['quantity'] > 0)->values();

        $user = $request->user();
        $couponService = app(CouponService::class);

        if (! $couponService->canApply($coupon, $items, $user)) {
            return back()->with('warning', 'This coupon cannot be applied to your cart.');
        }

        $request->session()->put('coupon_code', $coupon->code);

        return back()->with('success', sprintf('Coupon "%s" applied successfully.', $coupon->code));
    }

    public function removeCoupon(Request $request, string $slug): RedirectResponse
    {
        $request->session()->forget('coupon_code');

        return back()->with('success', 'Coupon removed.');
    }

    public function add(Request $request, AdminProduct $product): RedirectResponse|JsonResponse
    {
        if ($product->status !== 'published' || $product->stock_status !== 'in_stock' || $product->quantity <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'This product is out of stock.'], 422);
            }

            return back()->with('warning', 'This product is out of stock.');
        }

        $requested = max(1, min((int) $request->input('quantity', 1), $product->quantity));

        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = min(((int) ($cart[$product->id] ?? 0)) + $requested, $product->quantity);
        $this->storeCart($request, $cart);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Product added to cart.']);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, AdminProduct $product): RedirectResponse
    {
        abort_unless($product->status === 'published' && $product->stock_status === 'in_stock', 404);

        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:'.$product->quantity]]);
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = $validated['quantity'];
        $this->storeCart($request, $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, AdminProduct $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $this->storeCart($request, $cart);

        return back()->with('success', 'Product removed from cart.');
    }

    /**
     * @return array<int, int>
     */
    private function cartFromRequest(Request $request): array
    {
        $sessionCart = $request->session()->get('cart', []);
        if ($sessionCart !== [] || ! $request->user()?->isUser()) {
            return $sessionCart;
        }

        return $request->user()->cartItems()
            ->pluck('quantity', 'product_id')
            ->map(fn (mixed $quantity): int => (int) $quantity)
            ->all();
    }

    /**
     * @param array<int, int> $cart
     */
    private function storeCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);

        if (! $request->user()?->isUser()) {
            return;
        }

        CartItem::query()->where('user_id', $request->user()->id)->delete();
        foreach ($cart as $productId => $quantity) {
            if ($quantity > 0) {
                CartItem::create([
                    'user_id' => $request->user()->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }
    }
}
