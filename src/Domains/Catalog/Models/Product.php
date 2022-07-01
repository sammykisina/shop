<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\ProductFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
  use HasFactory;
  use HasUuid;

  protected $fillable = [
    'uuid',
    'name',
    'description',
    'cost',
    'retail',
    'active',
    'vat',
    'category_id',
    'range_id'
  ];

  protected $casts = [
    'active' => 'boolean'
  ];

  protected static function newFactory(): ProductFactory {
    return new ProductFactory();
  }
}
