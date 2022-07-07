<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Illuminate\Database\Eloquent\Model;

class AddProductToCart {
  
  
  /**
   * [Description for handle]
   *
   * @param int $purchasableID
   * @param string $purchasableType
   * @param Cart $cart
   * 
   * @return Model
   * 
   */
  public static function handle(int $purchasableID, string $purchasableType, Cart $cart ): Model {
    return $cart->items()->create([
      'purchasable_id' => $purchasableID,
      'purchasable_type' => $purchasableType,
      ]
    );
  }
}
