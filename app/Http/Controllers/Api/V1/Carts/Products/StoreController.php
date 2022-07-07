<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Products\ProductRequest;
use Domains\Customer\Factories\CartItemFactory;
use Domains\Customer\Jobs\Cart\AddProductToCart;
use Domains\Customer\Models\Cart;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller {
       

    /**
     * [Description for __invoke]
     *
     * @param ProductRequest $request
     * @param Cart $cart
     * 
     * @return Response
     * 
     */
    public function __invoke(ProductRequest $request, Cart $cart): Response {
        AddProductToCart::dispatch(
            CartItemFactory::make(
                attributes: $request->validated()
            ),
            $cart
        );

        return new Response(
            content: null,
            status: Http::CREATED
        );
    }
}
