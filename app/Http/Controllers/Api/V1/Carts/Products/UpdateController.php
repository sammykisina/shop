<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Products\UpdateRequest;
use Domains\Customer\Jobs\Cart\UpdateProductQuantity;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class UpdateController extends Controller {
    /**
     * [Description for __invoke]
     *
     * @param UpdateRequest $request
     * @param Cart $cart
     * @param CartItem $item
     * 
     * @return Response
     * 
     */
    public function __invoke(UpdateRequest $request, Cart $cart, CartItem $item): Response {
        UpdateProductQuantity::dispatch(
            cart: $cart,
            item: $item,
            quantity: $request->get(key: 'quantity')
        );

        return new Response(
            content: null,
            status: Http::ACCEPTED
        );
    }
}
