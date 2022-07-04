<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Models\Cart;

it('can store an event for adding a variant to cart', function () {
  $variant = Variant::factory()->create(); // Can Also Be A Bundle
  $cart = Cart::factory()->create();

  CartAggregate::fake()
    ->given(new ProductWasAddedToCart(
        purchasableID: $variant->id,
        cartID: $cart->id,
        type: Cart::class
      )
    )->when(
      function (CartAggregate $aggregate) use ($variant,$cart): void  {
      $aggregate->addProductToCart(
        purchasableID: $variant->id,
        cartID: $cart->id,
      );
    }
    )->assertEventRecorded(
      expectedEvent: new ProductWasAddedToCart(
        purchasableID: $variant->id,
        cartID: $cart->id,
        type: Cart::class
      )
    );
});