<?php

declare(strict_types=1);

use Domains\Customer\Models\Location;

dataset(
    name: 'location',
    dataset:[
    fn () => Location::factory()->create()
  ]
);
