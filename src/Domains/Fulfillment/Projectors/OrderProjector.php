<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Projectors;

use Domains\Fulfillment\Actions\Order\CreateOrder;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    /**
     * [Description for onOrderWasCreated]
     *
     * @param OrderWasCreated $event
     *
     * @return void
     *
     */
    public function onOrderWasCreated(OrderWasCreated $event): void
    {

        CreateOrder::handle(
            cart: $event->cart,
            shipping: $event->shipping,
            billing: $event->billing,
        );
    }
}
