<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Jobs;

use Domains\Fulfillment\Actions\RetrieveOrderStatusFromPaymentIntent;
use Domains\Fulfillment\Aggregates\OrderAggregate;
use Domains\Fulfillment\Models\Order;
use Domains\Fulfillment\States\Statuses\OrderStatus;
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

        // Look up an order by the intent id based off the object id
        $order = Order::query()
            ->where('intent_id',$this->paymentIntent->id)
            ->first();

        // Get the order status depending on the status of the webhook
        $status = RetrieveOrderStatusFromPaymentIntent::handle($this->paymentIntent);

        // calling the updateOrderStatus aggregate
        OrderAggregate::retrieve(
            uuid: $order->uuid
        )->updateOrderStatus(
            orderId: $order->id,
            status: $status->value
        )->persist();
    }
}
