<?php

declare(strict_types=1);


use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use Domains\Fulfillment\Aggregates\OrderAggregate;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Domains\Fulfillment\Factories\OrderFactory;

/**
 * These Tests Check If A Given An Event(s) And Associated With A Certain Aggregate, Will The Event Occur
 */

it('it can store an order was created event for an authenticated user', function (CartItem $cartItem, Location $location, User $user) {
    auth()->login(user: $user);
    OrderAggregate::fake()
   ->given(
       events: new OrderWasCreated(
        cart: $cartItem->cart->uuid,
        shipping: $location->id,
        billing: $location->id,
        userID: auth()->id(),
        intent: null
    )
   )->when(
        callable: function (OrderAggregate $aggregate) use ($cartItem, $location) {
          $aggregate->createOrder(
            order: OrderFactory::make(
                attributes:[
                  'cart' =>  $cartItem->cart->uuid,
                  'shipping' => $location->id,
                  'billing' =>  $location->id,
                  'intent' => null
                ]
            )
          );
      }
    )->assertRecorded(
        expectedEvents: new OrderWasCreated(
          cart: $cartItem->cart->uuid,
          shipping: $location->id,
          billing: $location->id,
          userID: auth()->id(),
          intent:null
      )
    );
})->with('cartItemWithQuantityOf3', 'location', 'user');
