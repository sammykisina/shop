<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use Domains\Customer\Jobs\Cart\Products\RemoveProductFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, Cart $cart, CartItem $item): Response
    {
        /**
         * Passing The Delete Processes To An UnderGround Job
         */
        RemoveProductFromCart::dispatch(
            cart: $cart,
            item: $item
        );

        return new Response(
            content: null,
            status: Http::ACCEPTED
        );
    }
}
