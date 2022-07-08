<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Cart\CartResource;
use Domains\Customer\Actions\Cart\CreateCart;
use Domains\Customer\Factories\CartFactory;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller {
    /**
     * @param Request $request
     * @return JsonResponse 
     */
    public function __invoke(Request $request) {
        $cart = CreateCart::handle(
            cart: CartFactory::make(
                attributes: [
                    'status' => CartStatus::pending()->value,
                    'user_id' => auth()->id ?? null
                ]
            )
        );

        /**
         * Return A JsonResponse
         */
        return new JsonResponse(
            data: new CartResource(
                resource: $cart
            ),
            status: Http::CREATED
        );
    }
}
