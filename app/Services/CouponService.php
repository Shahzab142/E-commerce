<?php

namespace App\Services;

use App\Models\AdminProduct;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;

class CouponService
{
    /**
      * Get the coupon currently stored in the session, if it is still valid.
      * Invalid/expired coupons are silently cleared from the session.
      */
    public function activeCoupon(Request $request): ?Coupon
    {
        $code = $request->session()->get('coupon_code');
        if (! $code) {
            return null;
        }

        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->isRedeemable()) {
            $request->session()->forget('coupon_code');

            return null;
        }

        return $coupon;
    }

    /**
      * Resolve the discount amount for the given cart items using the coupon
      * currently active in the session.
      *
      * For multi-vendor carts:
      * - Global coupons apply to the entire cart total.
      * - Vendor/product/category coupons only apply to eligible items.
      */
    public function discountFor(Request $request, iterable $items, ?User $user = null): float
    {
        $coupon = $this->activeCoupon($request);

        if (! $coupon) {
            return 0.0;
        }

        if (! $coupon->appliesToUser($user)) {
            return 0.0;
        }

        $eligibleSubtotal = 0.0;

        foreach ($items as $item) {
            $product = $item['product'] ?? null;

            if ($product instanceof AdminProduct) {
                if ($coupon->appliesToProduct($product)) {
                    $eligibleSubtotal += (float) ($item['subtotal'] ?? 0);
                }
            } else {
                // Fallback for non-product items (e.g., shipping or fees)
                $eligibleSubtotal += (float) ($item['subtotal'] ?? 0);
            }
        }

        if ($eligibleSubtotal < (float) $coupon->min_order_amount) {
            return 0.0;
        }

        $discount = $coupon->type === 'percent'
            ? $eligibleSubtotal * ((float) $coupon->value / 100)
            : (float) $coupon->value;

        if ($coupon->max_discount_amount !== null) {
            $discount = min($discount, (float) $coupon->max_discount_amount);
        }

        return round(min($discount, $eligibleSubtotal), 2);
    }

    /**
      * Validate that a coupon can be applied to the given cart items and user.
      */
    public function canApply(Coupon $coupon, iterable $items, ?User $user = null): bool
    {
        if (! $coupon->isRedeemable()) {
            return false;
        }

        if (! $coupon->appliesToUser($user)) {
            return false;
        }

        $eligibleSubtotal = 0.0;

        foreach ($items as $item) {
            $product = $item['product'] ?? null;

            if ($product instanceof AdminProduct) {
                if ($coupon->appliesToProduct($product)) {
                    $eligibleSubtotal += (float) ($item['subtotal'] ?? 0);
                }
            } else {
                $eligibleSubtotal += (float) ($item['subtotal'] ?? 0);
            }
        }

        return $eligibleSubtotal >= (float) $coupon->min_order_amount;
    }
}
