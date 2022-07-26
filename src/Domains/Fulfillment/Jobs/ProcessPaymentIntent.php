<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Jobs;

use Domains\Fulfillment\ValueObjects\PaymentIntentValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPaymentIntent implements ShouldQueue {
    use Dispatchable; 
    use InteractsWithQueue; 
    use Queueable; 
    use SerializesModels;

    public function __construct(
        public PaymentIntentValueObject $paymentIntent
    ){}

    public function handle(): void 
    {
        Log::info(
            message: 'Payment Info From The Webhooks',
            context: [
                'id' => $this->paymentIntent->id,
                'object' => $this->paymentIntent->object
            ]
        );
    }
}
