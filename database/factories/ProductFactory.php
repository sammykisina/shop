<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Category;
use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Range;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        $cost = fake()->numberBetween(int1:100, int2:100000);

        return [
            'name' => fake()->words(nb: 4, asText:true),
            'description' => fake()->paragraphs(nb:2, asText:true),
            'cost' => $cost,
            'retail' => ($cost *  config(key:'shop.profit_margin')), // Profit Is 40% Of The Cost
            'active' => fake()->boolean(),
            'vat' => config(key:'shop.vat'),
            'category_id' => Category::factory()->create(),
            'range_id' => fake()->boolean() ? Range::factory()->create() : null
        ];
    }
}
