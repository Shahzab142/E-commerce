<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A saved shipping address for a customer.
 *
 * Customers can save multiple addresses and select one at checkout.
 * When set as default, it will be pre-selected in the address picker.
 */
class ShippingAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'label',
        'full_name',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'landmark',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * The user this address belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is the default address for the user.
     */
    public function isDefaultForUser(int $userId): bool
    {
        return $this->user_id === $userId && $this->is_default;
    }

    /**
     * Scope to get only default addresses.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}