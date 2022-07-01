<?php

declare(strict_types=1);

namespace  Domains\Catalog\Models;

use Database\Factories\RangeFactory;
use Domains\Catalog\Models\Builders\RangeBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Range extends Model { // Summer_2022_Conference etc
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
      foreignKey: 'range_id'
    );
  }

  public function newEloquentBuilder($query): Builder {
    return new RangeBuilder(
      query: $query
    );
  }

  protected static function newFactory(): RangeFactory {
    return new RangeFactory();
  }
}
