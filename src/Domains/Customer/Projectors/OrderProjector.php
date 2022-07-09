<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\Order\CreateOrder;
use Domains\Customer\Events\Orders\OrderWasCreated;
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
            userID: $event->userID,
        );
    }
}
