<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Projectors;

use Domains\Fulfillment\Actions\CreateOrder;
use Domains\Fulfillment\Actions\UpdateOrderStatus;
use Domains\Fulfillment\Events\Orders\OrderStatusWasUpdated;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Domains\Fulfillment\Models\Order;
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
            intent: $event->intent
        );
    }

    /**
     * [Description for onOrderStatusWasUpdated]
     *
     * @param OrderStatusWasUpdated $event
     * 
     * @return void
     * 
     */
    public function onOrderStatusWasUpdated(OrderStatusWasUpdated $event): void 
    {
        $order = Order::query()->find($event->orderId);

        UpdateOrderStatus::handle(
            order: $order,
            status: $event->status
        );
    }
}
