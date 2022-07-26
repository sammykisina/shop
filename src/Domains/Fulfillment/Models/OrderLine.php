<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Models;

use Database\Factories\OrderLineFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
  use HasFactory;
  use HasUuid;

  protected $fillable = [
    'uuid',
    'name',
    'description',
    'retail',
    'cost',
    'quantity',
    'purchasable_id',
    'purchasable_type',
    'order_id'
  ];

  protected $cast = [
  //
  ];

  public function order(): BelongsTo 
  {
    return $this->belongsTo(
      related: Order::class,
      foreignKey: 'order_id'
    );
  }

  protected static function newFactory(): OrderLineFactory
  {
    return new OrderLineFactory();
  }
}
