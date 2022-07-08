<?php

declare(strict_types=1);

use Domains\Customer\Models\Coupon;

dataset(name: 'coupon', dataset: [
  fn() => Coupon::factory()->create()
]);