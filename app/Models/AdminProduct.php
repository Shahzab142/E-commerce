<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Coupon;

class AdminProduct extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Database Table
    |--------------------------------------------------------------------------
    |
    | Your model is called AdminProduct, but your database table is
    | called "products".
    |
    */

    protected $table = 'products';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'quantity',
        'stock_status',
        'category_id',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    protected static function booted(): void
    {
        /*
        |----------------------------------------------------------------------
        | Keep stock_status in sync with quantity automatically.
        |
        | The dashboard's inventory alert counts products by quantity, so a
        | stale manually-selected stock_status made the alert show wrong
        | numbers. Deriving it from quantity on every save keeps them equal.
        |----------------------------------------------------------------------
        */
        static::saving(function (AdminProduct $product): void {
            $product->stock_status = (int) ($product->quantity ?? 0) > 0
                ? 'in_stock'
                : 'out_of_stock';
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AdminCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(AdminProductImage::class, 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id')
            ->where('status', Review::STATUS_APPROVED);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class, 'product_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * The price the customer actually pays.
     */
    public function currentPrice(): float
    {
        return (float) ($this->sale_price ?? $this->regular_price);
    }

    /**
     * Discount percentage when a sale price is lower than the regular price.
     */
    public function discountPercent(): int
    {
        $regular = (float) $this->regular_price;
        $sale = $this->sale_price !== null ? (float) $this->sale_price : $regular;

        if ($sale <= 0 || $sale >= $regular) {
            return 0;
        }

        return (int) round(($regular - $sale) / $regular * 100);
    }

    /**
     * Whether the product can be purchased right now.
     */
    public function isInStock(): bool
    {
        return $this->stock_status === 'in_stock' && (int) $this->quantity > 0;
    }

    /**
      * Average rating of approved reviews (0 when none).
      */
    public function averageRating(): float
    {
        if ($this->relationLoaded('approvedReviews')) {
            return round((float) $this->approvedReviews->avg('rating'), 1);
        }

        return round((float) $this->approvedReviews()->avg('rating'), 1);
    }

    /**
      * Count of approved reviews.
      */
    public function reviewsCount(): int
    {
        if ($this->relationLoaded('approvedReviews')) {
            return (int) $this->approvedReviews->count();
        }

        return (int) $this->approvedReviews()->count();
    }
}
