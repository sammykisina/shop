<?php

declare(strict_types=1);

namespace  Domains\Catalog\Models;

use Database\Factories\VariantFactory;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\OrderLine;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Variant extends Model {
  use HasFactory;
  use HasUuid;

  protected $fillable = [
    'uuid',
    'name',
    'cost',
    'retail',
    'height',
    'width',
    'length',
    'active',
    'shippable',
    'product_id'
  ];

  protected $cast = [
    'active' => 'boolean',
    'shippable' => 'boolean'
  ];

  public function product(): BelongsTo {
    return $this->belongsTo(
      related: Product::class,
      foreignKey:'product_id'
    );
  }

  public function purchases(): MorphMany {
    return $this->morphMany(
      related: CartItem::class,
      name: 'purchasable'
    );
  }

  public function orders(): MorphMany {
    return $this->morphMany(
      related: OrderLine::class,
      name: 'purchasable'
    );
  }

  protected static function newFactory(): VariantFactory {
    return new VariantFactory();
  }
}
