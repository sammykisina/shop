<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Modals\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserFactory extends Factory {
    
    protected $model = User::class;

    public function definition(): array {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(value: 'password'), 
            'remember_token' => Str::random(10),
        ];
    }
}
