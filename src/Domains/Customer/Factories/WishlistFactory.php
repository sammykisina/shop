<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\WishlistValueObject;

class WishlistFactory
{
  /**
   * [Description for make]
   *
   * @param array $attributes
   * 
   * @return WishlistValueObject $wishlistValueObject
   * 
   */
  public static function make(array $attributes): WishlistValueObject
  {
    return new WishlistValueObject(
      name: $attributes['name'],
      public: $attributes['public'],
      user_id: $attributes['user_id'] 
    );
  }
}
