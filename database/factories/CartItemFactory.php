<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;
    public function definition(): array
    {
        $variant = Variant::factory()->create();
        $cart = Cart::factory()->create();

        return [
            'quantity' => fake()->numberBetween(int1: 1, int2: 12),
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant',
            'cart_id' => $cart->id
        ];
    }
}
