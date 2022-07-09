<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Order;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Order;
use Domains\Customer\States\Statuses\OrderStatus;

class CreateOrder
{
    /**
     * [Description for handle]
     *
     * @param string $cart
     * @param int $shipping
     * @param int $billing
     * @param null|int $userID
     *
     * @return void
     *
     */
    public static function handle(string $cart, int $shipping, int $billing, null|int $userID): void
    {
      $cart = Cart::query()
        ->with('items')
        ->where('uuid', $cart)->first();

      Order::query()->create([
        'number' => 'number',
        'status' => OrderStatus::pending()->label,
        'coupon' => $cart->coupon,
        'total' => 'value',
        'reduction' => $cart->reduction,
        'user_id' => $userID,
        'shipping_id' => $shipping,
        'billing_id' => $billing,
    ]);
    }
}
