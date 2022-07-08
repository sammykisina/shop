<?php

declare(strict_types=1);

use Domains\Customer\Factories\CartFactory;
use Domains\Customer\ValueObjects\CartValueObject;

it('can create and return a cart value object', function () {
    expect(
        CartFactory::make(
          attributes: [
          'status' => 'test status',
          'user_id' => 1
        ]
      )
    )->toBeInstanceOf(class: CartValueObject::class)
    ->status
    ->toBe(expected: 'test status');
});
