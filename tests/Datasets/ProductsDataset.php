<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;

dataset(name: 'variant', dataset: [
  fn () => Variant::factory()->create()
]);
