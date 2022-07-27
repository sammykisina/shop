<?php

declare(strict_types=1);

use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;

/**
 * These Tests Check If A Certain Endpoint Is Hit , Will The Correct Event Emitted And Stored
 */

it('can not create an order from a cart for an unauthenticated user', function (CartItem $cartItem, Location $location) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    post(
        route('api:v1:orders:store'),
        data:[
      'cart' => $cartItem->cart->uuid,
      'email' => 'sammy@gmail.com',
      'shipping' => $location->id,
      'billing' => $location->id,
      'intent' => 'intent'
    ]
    )->assertStatus(
        status: Http::UNAUTHORIZED
    );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
})->with('cartItemWithQuantityOf3', 'location');

it('can create an order from  a cart for an authenticated user', function (CartItem $cartItem, Location $location, User $user) {
    auth()->login($user);
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    post(
        route('api:v1:orders:store'),
        data:[
      'cart' => $cartItem->cart->uuid,
      'shipping' => $location->id,
      'billing' => $location->id,
      'intent' => 'intent'
    ]
    )->assertStatus(
        status: Http::CREATED
    );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: OrderWasCreated::class);
})->with('cartItemWithQuantityOf3', 'location', 'user');

