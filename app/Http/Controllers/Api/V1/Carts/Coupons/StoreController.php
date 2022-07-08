<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Coupons\StoreRequest;
use Domains\Customer\Jobs\Cart\Coupons\ApplyCoupon;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Cart $cart): Response
    {
        // $coupon = Coupon::query()->where(
        //     'code',
        //     $request->get(key: 'code')
        // )->firstOrFail();

        ApplyCoupon::dispatch(
            cart: $cart,
            code: $request->get(key:"code")
        );

        return new Response(
            content: null,
            status: Http::ACCEPTED
        );
    }
}
