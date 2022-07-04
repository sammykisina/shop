<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Illuminate\Support\Str;

class CartProjector extends Projector {
  public function onProductWasAddedToCart(ProductWasAddedToCart $event): void {
    $cart = Cart::query()->find(
      id: $event->cartID
    );

    $cart->items()->create([
      'purchasable_id' =>  $event->purchasableID,
      'purchasable_type' => $event->type
    ]);
  }

  public function onProductWasRemovedFromCart(ProductWasRemovedFromCart $event): void {
    $cart = Cart::query()->find(
      id: $event->cartID
    );

    $cart->items()
    ->where('purchasable_id', $event->purchasableID)
    ->where('purchasable_type' , $event->type)
    ->delete();
  }

  public function onProductQuantityWasIncreased(ProductQuantityWasIncreased $event): void {
    $cartItem = CartItem::query()
    ->where(
      column: 'cart_id',
      value: $event->cartID
    )
    ->where(
      column: 'id',
      value: $event->cartItemID
    )->first();

    $cartItem->update(values: [
      'quantity' => ($cartItem->quantity + $event->quantity)
    ]);
  }

  public function onProductQuantityWasDecreased(ProductQuantityWasDecreased $event): void {
    $cartItem = CartItem::query()
    ->where(
      column: 'cart_id',
      value: $event->cartID
    )
    ->where(
      column: 'id',
      value: $event->cartItemID
    )->first();

    if($event->quantity >= $cartItem->quantity) {
      CartAggregate::retrieve(
        uuid: Str::uuid()->toString()
      )->removeProductFromCart(
        purchasableID: $cartItem->purchasable->id,
        cartID: $event->cartID,
        type: get_class($cartItem->purchasable)
      );

      return;
    }

    $cartItem->update(values: [
      'quantity' => ($cartItem->quantity - $event->quantity)
    ]);
  }
}
 