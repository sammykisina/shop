<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Cart\Coupons;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;

class ApplyCoupon
{
    public static function handle(int $cartID, string $code): void
    {
        $coupon = Coupon::query()->where(
            'code',
            $code
        )->first();

        Cart::query()->where(
            'id',
            $cartID
        )->update([
      'coupon' => $coupon->code,
      'reduction' => $coupon->reduction
    ]);
    }
}
