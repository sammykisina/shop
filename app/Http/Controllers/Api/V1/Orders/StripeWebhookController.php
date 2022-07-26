<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use Domains\Fulfillment\Factories\PaymentIntentFactory;
use Domains\Fulfillment\Jobs\ProcessPaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller 
{
    public function __invoke(Request $request) 
    {
        if($request->get(key: 'type') === 'payment_intent.succeeded') {
            ProcessPaymentIntent::dispatch(
                PaymentIntentFactory::make(
                    event: $request->get(key: 'payload')
                )
            );
        } 
    }
}
