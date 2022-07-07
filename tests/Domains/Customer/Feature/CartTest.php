<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;


use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\assertDeleted;

it('can create a cart for an unauthenticated user') 
  -> post(
      uri: fn() => route('api:v1:carts:store')
    )->assertStatus(
      status: Http::CREATED
    )->assertJson(
    fn(AssertableJson $json) => 
      $json
        ->where(key: 'type' ,expected: 'cart')
        ->where(key: 'attributes.status', expected: CartStatus::pending()->label)
        ->etc()
);

it('can return a cart for an authenticated user', function() {
    $cart = Cart::factory()->create();
    auth()->loginUsingId($cart->user_id);

    get(
      route('api:v1:carts:index')
    )->assertStatus(
      status: Http::OK
    );
});

it('returns a no content status when a guest tries to retrieve their carts')
  ->get(
      uri: fn() => route('api:v1:carts:index')
    )->assertStatus(
    status: Http::NO_CONTENT
);

it('can add a product to cart',function () {
  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0); // No Event Yet

  // Add A Product
  $cart = Cart::factory()->create(); 
  $variant = Variant::factory()->create();
  
  post(
    route('api:v1:carts:products:store',$cart->uuid),
    data:[
      'purchasable_id' => $variant->id,
      'purchasable_type' => 'variant'
    ])->assertStatus(
    status: Http::CREATED
  );

  // Check The Stored Event
  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
  expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasAddedToCart::class);
});

it('can increase the quantity of item in the cart', function(){
  expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
  $cartItem = CartItem::factory()->create([
    'quantity' => 1
  ]);
  expect(value: $cartItem->quantity)->toEqual(expected: 1);

  patch(
    route(name: 'api:v1:carts:products:update',parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
    data: ['quantity' => 3]
  )->assertStatus(
    status: Http::ACCEPTED
  );

  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
  expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductQuantityWasIncreased::class);
});

it("can decrease the quantity of item in the cart" ,function() {
  expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
 $cartItem = CartItem::factory()->create([
    'quantity' => 3 
  ]);
  expect(value: $cartItem->quantity)->toEqual(expected: 3);

  patch(
    route(name: 'api:v1:carts:products:update',parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
    data: ['quantity' => 1]
  )->assertStatus(
    status: Http::ACCEPTED
  );

  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
  expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductQuantityWasDecreased::class);
});

it('can remove item from cart when the quantity is zero', function () {
  expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
  $cartItem = CartItem::factory()->create([
    'quantity' => 3 
  ]);

  expect(value: $cartItem->quantity)->toEqual(expected: 3);

  patch(
    route(name: 'api:v1:carts:products:update',parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
    data: ['quantity' => 0]
  )->assertStatus(
    status: Http::ACCEPTED
  );

  expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
  expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemovedFromCart::class);
});

