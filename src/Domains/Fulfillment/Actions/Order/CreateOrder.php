<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Actions\Order;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Fulfillment\Models\Order;
use Domains\Fulfillment\States\Statuses\OrderStatus;

class CreateOrder
{
    /**
     * [Description for handle]
     *
     * @param string $cart
     * @param int $shipping
     * @param int $billing
     *
     * @return void
     *
     */
    public static function handle(string $cart, int $shipping, int $billing): void
    {
      if(auth()->check()){
        $cart = Cart::query()
          ->with('items')
          ->where('uuid', $cart)->first();
          
        $order = Order::query()->create([
          'number' => 'number',
          'status' => OrderStatus::pending()->label,
          'coupon' => $cart->coupon,
          'total' => 'value',
          'reduction' => $cart->reduction,
          'user_id' => auth()->id(),
          'shipping_id' => $shipping,
          'billing_id' => $billing,
        ]);

        $cart->items->each(function(CartItem $cartItem) use($order){
          $order->orderItems()->create([
            'name' => $cartItem->purchasable->name,
            'description' => $cartItem->purchasable->product->description,
            'retail' => $cartItem->purchasable->retail, 
            'cost' => $cartItem->purchasable->cost,
            'quantity' => $cartItem->quantity,
            'purchasable_id' => $cartItem->purchasable->id,
            'purchasable_type' => strtolower(class_basename($cartItem->purchasable))
          ]);
        });
      }
    }
}
