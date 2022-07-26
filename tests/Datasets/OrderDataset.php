<?php

declare(strict_types=1);


use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;

dataset(
  name: 'orderWasCreatedForAnAuthenticatedUserEvent',
  dataset:[
    fn() => new OrderWasCreated(
      cart:( CartItem::factory()->create())->cart->uuid,
      shipping: ($location = Location::factory()->create())->id,
      billing: $location->id,
      userID:null
    )
  ]
);