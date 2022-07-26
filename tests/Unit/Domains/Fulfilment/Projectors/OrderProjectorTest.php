<?php

declare(strict_types=1);


use Domains\Customer\Models\User;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Domains\Fulfillment\Models\Order;
use Domains\Fulfillment\Models\OrderLine;
use Domains\Fulfillment\Projectors\OrderProjector;

beforeEach(fn() => $this->projector = new OrderProjector());

it('can create a order from a cart for authenticated users',function(OrderWasCreated $event, User $user) {
  
  auth()->login($user);
  expect(value: $this->projector)
    ->toBeInstanceOf(class: OrderProjector::class);
  expect(value: Order::query()->count())
    ->toEqual(expected: 0);
    
  $this->projector->onOrderWasCreated(
    event: $event
  );

  expect(value: Order::query()->count())
    ->toEqual(expected: 1);
  expect(value: OrderLine::query()->count())->toEqual(expected: 1);

})->with('orderWasCreatedForAnAuthenticatedUserEvent','user');