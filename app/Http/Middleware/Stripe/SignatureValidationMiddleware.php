<?php

declare(strict_types=1);

namespace App\Http\Middleware\Stripe;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JustSteveKing\StatusCode\Http;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\WebhookSignature;
use UnexpectedValueException;

class SignatureValidationMiddleware 
{
    /**
     * [Description for handle]
     *
     * @param Request $request
     * @param Closure $next
     * 
     * @return mixed
     * 
     */
    public function handle(Request $request, Closure $next): mixed 
    {
        try {
            $event = Webhook::constructEvent(
                payload: $request->getContent(),
                sigHeader: $request->header(key: 'Stripe-Signature'),
                secret: config(key: 'services.stripe.endpoint_secret')
            );
        } catch (UnexpectedValueException $e) {
            abort(code: Http::UNPROCESSABLE_ENTITY); //Invalid Payload
        } catch (SignatureVerificationException $e) {
            abort(Http::UNAUTHORIZED);
        }

        $request->merge([ 
            'payload' => $event
        ]);

        return $next($request);
    }
}
