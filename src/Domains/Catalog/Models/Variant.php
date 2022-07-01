<?php

declare(strict_types=1);

namespace  Domains\Catalog\Models;

use Database\Factories\VariantFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

  protected static function newFactory(): VariantFactory {
    return new VariantFactory();
  }
}
