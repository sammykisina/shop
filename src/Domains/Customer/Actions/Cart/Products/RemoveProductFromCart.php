<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Cart\Products;

use Domains\Customer\Models\Cart;

class RemoveProductFromCart
{
  /**
   * [Description for handle]
   *
   * @param int $purchasableID
   * @param string $purchasableType
   * @param Cart $cart
   *
   * @return void
   *
   */
    public static function handle(int $purchasableID, string $purchasableType, Cart $cart): void
    {
        $cart->items()
      ->where('purchasable_id', $purchasableID)
      ->where('purchasable_type', $purchasableType)
      ->delete();
    }
}
