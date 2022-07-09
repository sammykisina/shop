<?php

declare(strict_types=1);

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
