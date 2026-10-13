<?php

namespace App\Models;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'times_used',
        'expires_at',
        'is_active',
        'product_id',
        'category_id',
        'customer_id',
        'scope',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'times_used' => 'integer',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(AdminProduct::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AdminCategory::class, 'category_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Ledger of successful redemptions (see {@link CouponUsage}).
     */
    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
      * Whether the coupon can currently be redeemed at all (ignoring order total).
      */
    public function isRedeemable(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit !== null && $this->times_used >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
      * Calculate the discount amount for a given subtotal. Returns 0 if the
      * coupon does not apply (e.g. subtotal below the minimum order amount).
      */
    public function discountFor(float $subtotal): float
    {
        if (! $this->isRedeemable() || $subtotal < (float) $this->min_order_amount) {
            return 0.0;
        }

        $discount = $this->type === 'percent'
            ? $subtotal * ((float) $this->value / 100)
            : (float) $this->value;

        if ($this->max_discount_amount !== null) {
            $discount = min($discount, (float) $this->max_discount_amount);
        }

        return round(min($discount, $subtotal), 2);
    }

    /**
      * Check if this coupon applies to a given user.
      */
    public function appliesToUser(?User $user = null): bool
    {
        if ($this->scope === 'global') {
            return true;
        }

        if ($this->scope === 'customer' && $this->customer_id && $user) {
            return $this->customer_id === $user->id;
        }

        return false;
    }

    /**
      * Check if this coupon applies to a given product.
      */
    public function appliesToProduct(AdminProduct $product): bool
    {
        if ($this->scope === 'global') {
            return true;
        }

        if ($this->scope === 'product' && $this->product_id) {
            return $this->product_id === $product->id;
        }

        if ($this->scope === 'category' && $this->category_id) {
            return $this->category_id === $product->category_id;
        }

        return false;
    }
}
