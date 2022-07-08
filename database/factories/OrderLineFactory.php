<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;
    public function definition(): array
    {
        $variant = Variant::query()->inRandomOrder()->first();
        return [
            'name' => $variant->name,
            'description' => $variant->product->description,
            'cost' =>  $variant->cost,
            'retail' => $variant->retail,
            'quantity' => fake()->numberBetween(int1: 1, int2:7),
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant',
            'order_id' => Order::factory()->create()
        ];
    }
}
