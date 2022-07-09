<?php

declare(strict_types=1);

use Domains\Customer\Events\Carts\CouponWasApplied;
use Domains\Customer\Events\Carts\ProductQuantityWasDecreased;
use Domains\Customer\Events\Carts\ProductQuantityWasIncreased;
use Domains\Customer\Events\Carts\ProductWasAddedToCart;
use Domains\Customer\Events\Carts\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Projectors\CartProjector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

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

it('can decrease products quantity in the cart',function(ProductQuantityWasDecreased $event){
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class);

  $cart = Cart::query()->find($event->cartID);
  expect(value: $cart->items->first()->quantity)
    ->toEqual(expected: 3);

  $this->projector->onProductQuantityWasDecreased($event);

  expect(value: $cart->refresh()->items->first()->quantity)
    ->toEqual(expected: 1);

})->with('productQuantityWasDecreasedEvent');

it('can remove a product from cart if the quantity passed is >= the current quantity when decreasing the quantity', function(ProductQuantityWasDecreased $event) {
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class);
  expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

  $cart = Cart::query()->find($event->cartID);
  expect(value: $cart->items->first()->quantity)
    ->toEqual(expected: 1);

  $this->projector->onProductQuantityWasDecreased($event);

  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
  expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemovedFromCart::class);
})->with('productQuantityWasDecreasedWithMoreQuantityThanWhatsInCartEvent');

it('can apply a coupon to a cart',function (CouponWasApplied $event) {
  expect(value: $this->projector)
    ->toBeInstanceOf(class: CartProjector::class); 
  $cart =  Cart::query()->find($event->cartID);
  expect(value: $cart->coupon)->toBeNull();

  $this->projector->onCouponWasApplied($event);

  $cart->refresh();

  expect(value: $cart->coupon)->toBeString();
  expect(value: $cart->coupon)->toEqual(expected:$event->code);
})->with('applyCouponEvent');

