<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Aggregates;

use Domains\Fulfillment\Events\Orders\OrderWasCreated;
use Domains\Fulfillment\ValueObjects\OrderValueObject;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
    public function createOrder(OrderValueObject $order): self
    {
        $this->recordThat(
            domainEvent: new OrderWasCreated(
            cart: $order->cart,
            shipping: $order->shipping,
            billing: $order->billing,
            userID: auth()->id()
          )
        );

        return $this;
    }
}
