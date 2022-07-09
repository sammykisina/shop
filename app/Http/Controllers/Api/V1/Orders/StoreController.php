<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Orders\StoreRequest;
use Domains\Customer\Factories\OrderFactory;
use Domains\Customer\Jobs\Order\CreateOrder;
use JustSteveKing\StatusCode\Http;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): Response
    {
        CreateOrder::dispatch(
            OrderFactory::make(
                attributes:[
                    'cart' =>  $request->get(key: 'cart'),
                    'shipping' => $request->get(key: 'shipping'),
                    'billing' =>  $request->get(key: 'billing'),
                    'userID' =>  auth()->check() ? auth()->id() : null,
                    'email' => auth()->guest() ? $request->get(key: 'email') : auth()->user()->email,
                ]
            )
        );

        return new Response(
            content: null,
            status: Http::CREATED
        );
    }
}
