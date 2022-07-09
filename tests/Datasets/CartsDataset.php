<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\Carts\CouponWasApplied;
use Domains\Customer\Events\Carts\ProductQuantityWasDecreased;
use Domains\Customer\Events\Carts\ProductQuantityWasIncreased;
use Domains\Customer\Events\Carts\ProductWasAddedToCart;
use Domains\Customer\Events\Carts\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;

dataset(
    name: 'cart',
    dataset: [
    fn () => Cart::factory()->create()
  ]
);

dataset(
    name: 'cartItemWithQuantityOf1',
    dataset: [
    fn () => CartItem::factory()->create([
      'quantity' => 1
    ])
  ]
);

dataset(
    name: 'cartItemWithQuantityOf3',
    dataset: [
    fn () => CartItem::factory()->create([
      'quantity' => 3
    ])
  ]
);

dataset(
    name: 'cartWithCoupon',
    dataset:[
    function () {
        $coupon = Coupon::factory()->create();

        return Cart::factory()->create([
        'coupon' => $coupon->code,
        'reduction' => $coupon->reduction
      ]);
    }
  ]
);

/**
 * Events Dataset
 */
dataset(
  name:'productWasAddedToCartEvent',
  dataset: [
    fn() => new ProductWasAddedToCart(
      purchasableID: Variant::factory()->create()->id,
      purchasableType: 'variant',
      cartID: Cart::factory()->create([
        'total' => 0
      ])->id
    )
  ]
);

dataset(
  name:'productWasRemovedFromCartEvent',
  dataset: [
    fn() => new ProductWasRemovedFromCart(
      purchasableID: Variant::factory()->create()->id,
      purchasableType: 'variant',
      cartID: CartItem::factory()->create()->cart_id
    )
  ]
);

dataset(
  name: 'productQuantityWasIncreasedEvent',
  dataset:[
    fn() => new ProductQuantityWasIncreased(
      cartID: ($cart = Cart::factory()->create())->id,
      cartItemID:CartItem::factory()->create([ 
        'cart_id' => $cart->id,
        'quantity' => 1
      ])->id,
      quantity: 1
    )
  ]
);


dataset(
  name: 'productQuantityWasDecreasedEvent',
  dataset:[
    fn() => new ProductQuantityWasDecreased(
      cartID: ($cart = Cart::factory()->create())->id,
      cartItemID:CartItem::factory()->create([ 
        'cart_id' => $cart->id,
        'quantity' => 3
        ])->id,
        quantity: 2
        )
        ]
      );
      
dataset(
  name: 'productQuantityWasDecreasedWithMoreQuantityThanWhatsInCartEvent',
  dataset:[
    fn() => new ProductQuantityWasDecreased(
      cartID: ($cart = Cart::factory()->create())->id,
      cartItemID:CartItem::factory()->create([ 
        'cart_id' => $cart->id,
        'quantity' => 1
      ])->id,
      quantity: 5
    )
  ]
);

dataset(
  name: 'applyCouponEvent',
  dataset:[
    fn() => new CouponWasApplied(
      cartID: Cart::factory()->create()->id,
      code: Coupon::factory()->create()->code
    )
  ]
);