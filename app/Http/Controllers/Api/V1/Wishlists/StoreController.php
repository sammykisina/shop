<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Wishlists;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Wishlists\StoreRequest;
use App\Http\Resources\Api\V1\WishlistResource;
use Domains\Customer\Actions\Wishlist\CreateWishlist;
use Domains\Customer\Factories\WishlistFactory;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller 
{
    public function __invoke(StoreRequest $request): JsonResponse 
    {
        // call the create wishlist action to create the wishlist
        $wishlist = CreateWishlist::handle(
            wishlistValueObject: WishlistFactory::make(
                attributes: [
                    'name' => $request->get(key: 'name'),
                    'public' => $request->get(key: 'public', default: false),
                    'user_id' => auth()->id() ?? null  
                ]
            ) 
        );

        return new JsonResponse(
            data: new WishlistResource(
                resource: $wishlist
            ),
            status: Http::CREATED
        );
    }
}
