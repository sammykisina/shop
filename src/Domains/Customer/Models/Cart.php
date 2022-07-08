<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CartFactory;
use Domains\Customer\States\Statuses\CartStatus;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    use HasUuid;
    use Prunable;

    protected $fillable = [
    'uuid',
    'status',
    'coupon',
    'total',
    'reduction',
    'user_id'
  ];

    protected $casts = [
    'status' => CartStatus::class.':nullable'
  ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey:'user_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            related: CartItem::class,
            foreignKey: 'cart_id'
        );
    }

    /**
     * Get The Prunable Modal Query
     * @return Builder
     */
    public function prunable()
    {
        return static::query()->where(
            column: 'created_at',
            operator: '<=',
            value: now()->subMonth()
        );
    }

    protected static function newFactory(): CartFactory
    {
        return new CartFactory();
    }
}
