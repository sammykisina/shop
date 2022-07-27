<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\User;
use Domains\Customer\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory {
    
    protected $model = Wishlist::class;
    public function definition(): array {
        return [
            'name' => fake()->words(nb: 3, asText: true),
            'public' => fake()->boolean(),
            'user_id' => User::factory()->create()
        ];
    }
}
