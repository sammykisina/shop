<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\WishlistFactory;
use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Builders\WishlistBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model {
  use HasFactory;
  use HasUuid;
  use SoftDeletes;

  protected $fillable = [
    'uuid',
    'name',
    'public',
    'user_id'
  ];

  protected $cast = [
    'public' => 'boolean'
  ];

  public function products(): BelongsToMany
  {
    return $this->belongsToMany(
      related: Variant::class,
      table: 'product_wishlist',
    );
  }

  public function owner(): BelongsTo
  {
    return $this->belongsTo(
      related: User::class,
      foreignKey: 'user_id'
    );
  }

  public function newEloquentBuilder($query): Builder
  {
    return new WishlistBuilder(
      query: $query
    );
  }
 
  protected static function newFactory(): WishlistFactory 
  {
    return new WishlistFactory();
  }
}
