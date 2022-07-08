<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;


use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;

it('can create a cart for an unauthenticated user')
  -> post(
      uri: fn () => route('api:v1:carts:store')
  )->assertStatus(
        status: Http::CREATED
    )->assertJson(
      fn (AssertableJson $json) =>
  $json
  ->where(key: 'type', expected: 'cart')
  ->where(key: 'attributes.status', expected: CartStatus::pending()->label)
  ->etc()
);

it('can return a cart for an authenticated user', function (Cart $cart) {
    auth()->loginUsingId($cart->user_id);

    get(
        route('api:v1:carts:index')
    )->assertStatus(
      status: Http::OK
  );
})->with('cart');

it('returns a no content status when a guest tries to retrieve their carts')
  ->get(
      uri: fn () => route('api:v1:carts:index')
  )->assertStatus(
        status: Http::NO_CONTENT
    );

it('can add a product to cart', function (Cart $cart, Variant $variant) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    post(
        route('api:v1:carts:products:store', $cart->uuid),
        data:[
      'purchasable_id' => $variant->id,
      'purchasable_type' => 'variant'
    ]
    )->assertStatus(
        status: Http::CREATED
    );

    // Check The Stored Event
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasAddedToCart::class);
})->with('cart', 'variant');

it('can increase the quantity of item in the cart', function (CartItem $cartItem) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    expect(value: $cartItem->quantity)->toEqual(expected: 1);

    patch(
        route(name: 'api:v1:carts:products:update', parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
        data: ['quantity' => 3]
    )->assertStatus(
      status: Http::ACCEPTED
  );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductQuantityWasIncreased::class);
})->with('cartItemWithQuantityOf1');

it("can decrease the quantity of item in the cart", function (CartItem $cartItem) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    expect(value: $cartItem->quantity)->toEqual(expected: 3);

    patch(
        route(name: 'api:v1:carts:products:update', parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
        data: ['quantity' => 1]
    )->assertStatus(
      status: Http::ACCEPTED
  );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductQuantityWasDecreased::class);
})->with('cartItemWithQuantityOf3');

it('can remove item from cart when the quantity is zero', function (CartItem $cartItem) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    expect(value: $cartItem->quantity)->toEqual(expected: 3);

    patch(
        route(name: 'api:v1:carts:products:update', parameters:[
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ]),
        data: ['quantity' => 0]
    )->assertStatus(
      status: Http::ACCEPTED
  );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemovedFromCart::class);
})->with('cartItemWithQuantityOf3');

it('can remove an item from the cart', function (CartItem $cartItem) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    delete(
        route(name:'api:v1:carts:products:delete', parameters: [
      'cart' => $cartItem->cart->uuid,
      'item' => $cartItem->uuid
    ])
    )->assertStatus(
      status: Http::ACCEPTED
  );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: ProductWasRemovedFromCart::class);
})->with('cartItemWithQuantityOf3');

it('can apply coupon to the cart', function (Coupon $coupon, Cart $cart) {
    expect(value: EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    expect(value: $cart)->reduction->toEqual(expected: 0);

    post(
        route(name: 'api:v1:carts:coupons:store', parameters: $cart->uuid),
        data: [
      'code' => $coupon->code
    ]
    )->assertStatus(
      status: Http::ACCEPTED
  );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(expected: CouponWasApplied::class);
})->with('coupon', 'cart');
