<?php

declare(strict_types=1);

use Domains\Customer\Aggregates\OrderAggregate;
use Domains\Customer\Events\Orders\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;

it('it can store an order was created event for an unauthenticated user', function (CartItem $cartItem, Location $location) {
    OrderAggregate::fake()
   ->given(
       events: new OrderWasCreated(
        cart: $cartItem->cart->uuid,
        shipping: $location->id,
        billing: $location->id,
        userID: null,
        email: 'sammy@gmail.com',
    )
   )->when(
        callable: function (OrderAggregate $aggregate) use ($cartItem, $location) {
          $aggregate->createOrder(
              cart: $cartItem->cart->uuid,
              shipping: $location->id,
              billing: $location->id,
              userID: null,
              email: 'sammy@gmail.com',
          );
      }
    )->assertRecorded(
        expectedEvents: new OrderWasCreated(
          cart: $cartItem->cart->uuid,
          shipping: $location->id,
          billing: $location->id,
          userID: null,
          email: 'sammy@gmail.com',
      )
    );
})->with('cartItemWithQuantityOf3', 'location');

it('it can store an order was created event for an authenticated user', function (CartItem $cartItem, Location $location, User $user) {
    auth()->login(user: $user);
    OrderAggregate::fake()
   ->given(
       events: new OrderWasCreated(
        cart: $cartItem->cart->uuid,
        shipping: $location->id,
        billing: $location->id,
        userID: auth()->id(),
        email:  auth()->user()->email,
    )
   )->when(
        callable: function (OrderAggregate $aggregate) use ($cartItem, $location, $user) {
          $aggregate->createOrder(
              cart: $cartItem->cart->uuid,
              shipping: $location->id,
              billing: $location->id,
              userID: auth()->id(),
              email:  auth()->user()->email,
          );
      }
    )->assertRecorded(
        expectedEvents: new OrderWasCreated(
          cart: $cartItem->cart->uuid,
          shipping: $location->id,
          billing: $location->id,
          userID: auth()->id(),
          email:  auth()->user()->email,
      )
    );
})->with('cartItemWithQuantityOf3', 'location', 'user');
