<?php

declare(strict_types=1);

use Domains\Customer\Events\Carts\CouponWasApplied;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;


use function Pest\Laravel\get;
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

it('can remove a coupon from cart', function (Cart $cartWithCoupon): void {
    expect(value: $cartWithCoupon->refresh())->coupon->toBeString();

    $coupon = Coupon::query()->where(
        'code',
        $cartWithCoupon->coupon
    )->first();

    delete(
        route('api:v1:carts:coupon:delete', [
            'cart' => $cartWithCoupon->uuid,
            'uuid' => $coupon->uuid
        ])
    )->assertStatus(Http::ACCEPTED);

    expect(value: $cartWithCoupon->refresh())->coupon->toBENull();
})->with('cartWithCoupon');
