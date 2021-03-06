<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\User;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CartFactory extends Factory
{
    protected $model = Cart::class;
    public function definition(): array
    {
        return [
            'status' => Arr::random(
                array: CartStatus::toLabels()
            ),
            'coupon' => null,
            'total' => fake()->numberBetween(int1: 1000, int2: 100000),
            'reduction' => 0 ,
            'user_id' => User::factory()->create()
        ];
    }
}
