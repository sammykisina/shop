<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\ProductFactory;
use Domains\Catalog\Models\Builders\ProductBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
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
    'active' => 'boolean',
    'vat' => 'boolean'
  ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: Category::class,
            foreignKey:"category_id"
        );
    }

    public function range(): BelongsTo
    {
        return $this->belongsTo(
            related: Range::class,
            foreignKey:"range_id"
        );
    }

    public function variants(): HasMany
    {
        return $this->hasMany(
            related: Variant::class,
            foreignKey: 'product_id'
        );
    }

    public function newEloquentBuilder($query): Builder
    {
        return new ProductBuilder(
            query: $query
        );
    }

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory();
    }
}
