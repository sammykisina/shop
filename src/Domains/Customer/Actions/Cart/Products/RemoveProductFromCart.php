<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Cart\Products;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

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

      $items = CartItem::query()
        ->with(['purchasable'])
        ->get();

       $item =  $items->filter(fn(Model $item) => 
          $item->id === $purchasableID
        )->first();

      if($items->count() === 1) {
        $cart->update([
          'total' => 0
        ]);
      }else {
        $cart->update([
          'total' => ($cart->total - $item->purchasable->retail)
        ]);
      }
      
      $cart->items()
        ->where('purchasable_id', $item->purchasable->id)
        ->where(
          'purchasable_type', 
          strtolower(class_basename($item->purchasable))
        )->delete();
    }
}
