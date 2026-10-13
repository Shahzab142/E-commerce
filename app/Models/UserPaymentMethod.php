<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A payment method a customer saved in their dashboard.
 *
 * Rows are soft deleted: when a customer removes a saved method it is only
 * hidden from them — the record stays in the database.
 */
class UserPaymentMethod extends Model
{
    use SoftDeletes;

    public const TYPE_EASYPAISA = 'easypaisa';

    public const TYPE_JAZZCASH = 'jazzcash';

    public const TYPE_BANK = 'bank';

    protected $fillable = [
        'user_id',
        'type',
        'account_title',
        'account_number',
        'bank_name',
        'iban',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Human label for the type.
     */
    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_EASYPAISA => 'EasyPaisa',
            self::TYPE_JAZZCASH => 'JazzCash',
            default => 'Bank Transfer',
        };
    }
}
