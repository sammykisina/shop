<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Events\Orders;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderStatusWasUpdated extends ShouldBeStored
{
  public function __construct(
    public int $orderId,
    public string $status
  ){} 
}
