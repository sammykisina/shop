<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\CategoryFactory;
use Domains\Catalog\Models\Builders\CategoryBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model { // T-Shirts, Hats etc
  use HasFactory;
  use HasUuid;

  public $timestamps = false;

  protected $fillable = [
    'uuid',
    'name',
    'description',
    'active'
  ];

  protected $casts = [
    'active' => 'boolean'
  ];

  public function products(): HasMany {
    return $this->hasMany(
      related: Product::class,
      foreignKey: 'category_id'
    );
  }

  public function newEloquentBuilder($query): Builder {
    return new CategoryBuilder(
      query: $query
    );
  }

  protected static function newFactory(): CategoryFactory {
    return new CategoryFactory();
  }
}
