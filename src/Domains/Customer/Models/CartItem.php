<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CartItemFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CartItem extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
    'uuid',
    'purchasable_id',
    'purchasable_type',
    'quantity',
    'cart_id'
  ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(
            related: Cart::class,
            foreignKey: 'cart_id'
        );
    }

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): CartItemFactory
    {
        return new CartItemFactory();
    }
}
