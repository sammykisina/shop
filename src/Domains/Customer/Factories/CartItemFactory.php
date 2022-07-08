<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\CartItemValueObject;

class CartItemFactory
{
  /**
   * [Description for make]
   *
   * @param array $attributes
   *
   * @return CartItemValueObject
   *
   */
    public static function make(array $attributes): CartItemValueObject
    {
        return new CartItemValueObject(
            purchasableID: $attributes['purchasable_id'],
            purchasableType: $attributes['purchasable_type']
        );
    }
}
