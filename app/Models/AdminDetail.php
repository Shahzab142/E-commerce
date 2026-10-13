<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminDetail extends Model
{
    protected $fillable = [
        'user_id',
        'country', 'state', 'city', 'postal_code', 'address', 'image', 'logo',
        'easypaisa_number', 'easypaisa_account_title',
        'jazzcash_number', 'jazzcash_account_title',
        'bank_name', 'account_title', 'account_number', 'iban',
        'stripe_account_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin's image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return asset('assets/images/user.png');
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return Storage::disk('public')->url($this->logo);
        }

        return asset('assets/images/user.png');
    }
}
