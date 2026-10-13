<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'role',
        'email_verified_at',
    ];

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EMPLOYEE = 'employee';
    public const ROLE_VENDOR = 'vendor';
    public const ROLE_USER = 'user';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUSPENDED = 'suspended';

    /**
     * Admin Details
     */
    public function adminDetail(): HasOne
    {
        return $this->hasOne(AdminDetail::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(AdminProduct::class, 'vendor_id');
    }

    public function customerOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Payment methods the customer saved in their dashboard (soft-deletable).
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(UserPaymentMethod::class);
    }

    /**
     * Saved shipping addresses (soft-deletable).
     */
    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helpers
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isSuspended(): bool
    {
        return in_array($this->status, [self::STATUS_SUSPENDED, 'suspend'], true);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Route
    |--------------------------------------------------------------------------
    */

    /**
     * Return dashboard route according to user role.
     */
    public function dashboardRoute(): string
    {
        return match ($this->role) {

            self::ROLE_ADMIN => 'admin.dashboard',

            self::ROLE_EMPLOYEE => 'employee.dashboard',

            default => 'user.dashboard',

        };
    }

    /*
    |--------------------------------------------------------------------------
    | Initials
    |--------------------------------------------------------------------------
    */

    /**
     * Get user's initials.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return asset('assets/images/user.png');
    }

    /**
     * Get vendor's average rating across all products.
     */
    public function averageRating(): float
    {
        if (!$this->isVendor()) {
            return 0;
        }

        return round(
            (float) $this->products()
                ->join('reviews', 'products.id', '=', 'reviews.product_id')
                ->where('reviews.status', 'approved')
                ->avg('reviews.rating') ?? 0,
            1
        );
    }

    /**
     * Get vendor's total sales count.
     */
    public function totalSales(): int
    {
        if (!$this->isVendor()) {
            return 0;
        }

        return (int) OrderItem::query()
            ->whereHas('product', fn ($q) => $q->where('vendor_id', $this->id))
            ->whereHas('order', fn ($q) => $q->whereNotIn('status', ['cancelled']))
            ->sum('quantity');
    }

    /**
     * Get vendor storefront URL.
     */
    public function storefrontUrl(): string
    {
        return route('vendor.store', $this->id);
    }
}


