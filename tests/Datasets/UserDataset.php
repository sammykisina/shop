<?php

declare(strict_types=1);

use Domains\Customer\Models\User;

dataset(
    name: 'user',
    dataset: [
    fn () => User::factory()->create()
  ]
);
