<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Customer\Events\Orders\OrderWasCreated;
use Domains\Customer\ValueObjects\OrderValueObject;
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
          userID: $order->userID,
          email: $order->email
      )
        );

        return $this;
    }
}
