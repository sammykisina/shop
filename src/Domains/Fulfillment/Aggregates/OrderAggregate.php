<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Aggregates;

use Domains\Fulfillment\Events\Orders\OrderStatusWasUpdated;
use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Domains\Fulfillment\ValueObjects\OrderValueObject;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
    /**
     * [Description for createOrder]
     *
     * @param OrderValueObject $order
     * 
     * @return self
     * 
     */
    public function createOrder(OrderValueObject $order): self
    {
        $this->recordThat(
            domainEvent: new OrderWasCreated(
            cart: $order->cart,
            shipping: $order->shipping,
            billing: $order->billing,
            userID: auth()->id(),
            intent: $order->intent
          )
        );

        return $this;
    }

    /**
     * [Description for updateOrderStatus]
     *
     * @param int $orderId
     * @param string $status
     * 
     * @return self
     * 
     */
    public function updateOrderStatus(int $orderId, string $status): self 
    {
        $this->recordThat(
            domainEvent: new OrderStatusWasUpdated(
                orderId: $orderId,
                status: $status
            )
        );
        return $this;
    }
}
