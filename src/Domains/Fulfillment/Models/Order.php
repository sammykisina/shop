<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Models;

use Database\Factories\OrderFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
    'uuid',
    'number',
    'status',
    'coupon',
    'intent_id',
    'total',
    'reduction',
    'user_id',
    'shipping_id',
    'billing_id',
    'completed_at',
    'cancelled_at'
  ];

    protected $cast = [
    'completed_at' => 'datetime',
    'cancelled_at' => 'datetime'
  ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id'
        );
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(
            related: Location::class,
            foreignKey: 'shipping_id'
        );
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(
            related: Location::class,
            foreignKey: 'billing_id'
        );
    }

    public function orderItems(): HasMany 
    {
        return $this->hasMany(
            related: OrderLine::class,
            foreignKey: 'order_id'
        );
    }


    protected static function newFactory(): OrderFactory
    {
        return new OrderFactory();
    }
}
