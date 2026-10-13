<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    public const ACTION_ORDER_DELETED = 'order.deleted';
    public const ACTION_ORDER_RESTORED = 'order.restored';
    public const ACTION_ORDER_STATUS = 'order.status';
    public const ACTION_ORDER_PURGED = 'order.purged';
    public const ACTION_USER_APPROVED = 'user.approved';
    public const ACTION_USER_BLOCKED = 'user.blocked';
    public const ACTION_USER_DELETED = 'user.deleted';
    public const ACTION_USER_RESTORED = 'user.restored';
    public const ACTION_USER_PURGED = 'user.purged';
    public const ACTION_PRODUCT_CREATED = 'product.created';
    public const ACTION_PRODUCT_UPDATED = 'product.updated';
    public const ACTION_PRODUCT_DELETED = 'product.deleted';
    public const ACTION_ORDER_CANCELLED = 'order.cancelled';
    public const ACTION_REVIEW_APPROVED = 'review.approved';
    public const ACTION_REVIEW_REJECTED = 'review.rejected';
    public const ACTION_REVIEW_PENDING = 'review.pending';

    protected $fillable = [
        'actor_id',
        'actor_role',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Persist a single activity entry.
     */
    public static function record(
        int $actorId,
        string $actorRole,
        string $action,
        string $description,
        ?Model $subject = null,
        array $metadata = [],
    ): self {
        return static::create([
            'actor_id' => $actorId,
            'actor_role' => $actorRole,
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'metadata' => $metadata ?: null,
        ]);
    }
}
