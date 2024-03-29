<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Events\Orders;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderWasCreated extends ShouldBeStored
{
    /**
     * [Description for __construct]
     *
     * @param  public string $cart
     * @param  public int $shipping
     * @param  public int $billing
     * @param  public null|int $userID
     * @param  public null|string $intent
     *
     */
    public function __construct(
        public string $cart,
        public int $shipping,
        public int $billing,
        public null|int $userID,
        public null|string $intent
    ) {
    }
}
