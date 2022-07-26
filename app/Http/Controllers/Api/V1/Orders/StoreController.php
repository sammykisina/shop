<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Orders\StoreRequest;
use Domains\Fulfillment\Factories\OrderFactory;
use Domains\Fulfillment\Jobs\CreateOrder;
use JustSteveKing\StatusCode\Http;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): Response
    {
        if(auth()->check()){
            CreateOrder::dispatch(
                OrderFactory::make(
                    attributes:[
                        'cart' =>  $request->get(key: 'cart'),
                        'shipping' => $request->get(key: 'shipping'),
                        'billing' =>  $request->get(key: 'billing'),
                        'intent' => $request->get(key: 'intent')
                    ]
                )
            );

            return new Response(
                content: null,
                status: Http::CREATED
            );
        } else {
            return new Response(
                content: null,
                status: Http::UNAUTHORIZED
            );
        }

    }
}
