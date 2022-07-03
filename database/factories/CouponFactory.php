<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory {
    
    protected $model = Coupon::class;
    public function definition(): array {
        $max_uses = fake()->numberBetween(int1:10,int2: 1000);
        return [
            'code' => fake()->bothify(
                string: 'COUP-????-????',
            ),
            'reduction' => fake()->numberBetween(int1:100, int2:5000),
            'uses' => fake()->numberBetween(int1:1, int2:$max_uses),
            'max_uses' => fake()->boolean() ? $max_uses : null,
            'active' => fake()->boolean()
        ];
    }
}
