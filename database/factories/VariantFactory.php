<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory {
    
    protected $model = Variant::class;
    public function definition(): array {
        $product = Product::factory()->create();
        $cost = fake()->boolean() ? $product->cost : ($product->cost + fake()->numberBetween(int1:100,int2:7500));
        $shippable = fake()->boolean();


        return [
            'name' => fake()->words(nb:3,asText:true),
            'cost' => $cost,
            'retail' => ($product->cost === $cost) ? $product ->retail : ($product->retail + fake()->numberBetween(int1:100,int2:7500)),
            'height' => $shippable ? fake()->numberBetween(int1:100,int2:10000) : null,
            'length' => $shippable ? fake()->numberBetween(int1:100,int2:10000) : null,
            'width' => $shippable ? fake()->numberBetween(int1:100,int2:10000) : null,
            'weight' => $shippable ? fake()->numberBetween(int1:100,int2:10000) : null,
            'active' => fake()->boolean(),
            'shippable' => $shippable,
            'product_id' => $product->id,
        ];
    }
}
