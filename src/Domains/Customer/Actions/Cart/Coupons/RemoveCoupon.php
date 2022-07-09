<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Cart\Coupons;

use Domains\Customer\Models\Cart;

class RemoveCoupon
{
    /**
     * [Description for handle]
     *
     * @param Cart $cart
     *
     * @return void
     *
     */
    public static function handle(Cart $cart): void
    {
        $cart->update([
            'coupon' => null,
            'reduction' => 0
        ]);
    }
}
