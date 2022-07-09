<?php

declare(strict_types=1);

use Domains\Customer\Events\Carts\ProductQuantityWasIncreased;
use Domains\Customer\Events\Carts\ProductWasAddedToCart;
use Domains\Customer\Events\Carts\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Projectors\CartProjector;

beforeEach(fn() => $this->projector = new CartProjector());

it('can add a product to cart', function(ProductWasAddedToCart $event) {
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class);

  $cart = Cart::query()->with(['items.purchasable'])
    ->find($event->cartID);

  expect(
    value: $cart->items->count()
  )->toEqual(expected: 0);

  expect(
    value: $cart->total,
  )->toEqual(expected: 0);

  $this->projector->onProductWasAddedToCart(
    event: $event
  );

  $cart->refresh();

  expect(
    value: $cart->items->count()
  )->toEqual(expected: 1);

  expect(
    value: $cart->total
  )->toEqual(expected: ($cart->items->first()->purchasable->retail));
  
})->with('productWasAddedToCartEvent');

it('can remove product from cart', function (ProductWasRemovedFromCart $event) {
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class);

  $cart = Cart::query()->with(['items.purchasable'])
    ->find($event->cartID);

  expect(
    value: $cart->items->count()
  )->toEqual(expected: 1);


  $this->projector->onProductWasRemovedFromCart(
    event: $event
  );

  $cart->refresh();

  expect(
    value: $cart->items->count()
  )->toEqual(expected: 0);

  expect(
    value: $cart->total
  )->toEqual(expected: 0);

})->with('productWasRemovedFromCartEvent');

it('can increase the quantity of product in the cart', function(ProductQuantityWasIncreased $event) {
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class);

  $cart = Cart::query()->find($event->cartID);
  expect(value: $cart->items->first()->quantity)
    ->toEqual(expected: 1);

  $this->projector->onProductQuantityWasIncreased($event);

  expect(value: $cart->refresh()->items->first()->quantity)
    ->toEqual(expected: 2);

})->with('productQuantityWasIncreasedEvent');