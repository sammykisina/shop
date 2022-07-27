<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use Domains\Fulfillment\Models\Order;
use Domains\Fulfillment\States\Statuses\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array
    {
        $useCoupon = fake()->boolean();
        $status = Arr::random(OrderStatus::toLabels());

        return [
            'number' => fake()->bothify(
                string: 'ORD-####-####-#####-####'
            ),
            'status' => $status,
            'coupon' => $useCoupon ? fake()->imei() : null,
            'total' => fake()->numberBetween(int1: 1000, int2: 100000),
            'reduction' => $useCoupon ? fake()->numberBetween(int1: 250, int2: 2500) : 0 ,
            'user_id' => User::factory()->create(),
            'shipping_id' => Location::factory()->create(),
            'billing_id' => Location::factory()->create(),
            'completed_at' => $status === 'complete' ? now() : null,
            'cancelled_at' => $status === 'cancelled' ? now() : null
        ];
    }
}
