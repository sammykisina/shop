<?php

declare(strict_types=1);

use function Pest\Laravel\post;

// it('passes the middleware check for a valid signature', function () {

//   $secret = config(key: 'services.stripe.endpoint_secret');
//   $time = time();
//   $payload = file_get_contents(filename: __DIR__ .'./Fixtures/payment-intent.json');

//   $timeStampedPayLoad = $time . "." . $payload;
//   $signature = hash_hmac('sha256', $timeStampedPayLoad,$secret);

//   post(
//     route('api:v1:stripe:webhooks'),
//     data: (array) $payload,
//     headers: [
//       'Stripe-Signature' => "t={$time},v1={$signature}" 
//     ]
//   )->assertOk();
// });