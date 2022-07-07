<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\AddProductToCart;
use Domains\Customer\Actions\RemoveProductFromCart;
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

  /**
   * [Description for onProductWasAddedToCart]
   *
   * @param ProductWasAddedToCart $event
   * 
   * @return void
   * 
   */
  public function onProductWasAddedToCart(ProductWasAddedToCart $event): void {
    $cart = Cart::query()->find(
      id: $event->cartID
    );

    /**
     * Actual Addition Of Product To Cart
     */
    AddProductToCart::handle(
      purchasableID: $event->purchasableID,
      purchasableType: $event->purchasableType,
      cart: $cart,
    );
  }

  /**
   * [Description for onProductWasRemovedFromCart]
   *
   * @param ProductWasRemovedFromCart $event
   * 
   * @return void
   * 
   */
  public function onProductWasRemovedFromCart(ProductWasRemovedFromCart $event): void {
    $cart = Cart::query()->find(
      id: $event->cartID
    );

    RemoveProductFromCart::handle(
      purchasableID: $event->purchasableID,
      purchasableType: $event->purchasableType,
      cart: $cart,
    ); 
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
        purchasableID: $cartItem->purchasable_id,
        purchasableType: $cartItem->purchasable_type,
        cartID: $event->cartID,
      );

      return;
    }

    $cartItem->update(values: [
      'quantity' => ($cartItem->quantity - $event->quantity)
    ]);
  }
}
 