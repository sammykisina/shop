<?php

declare(strict_types=1);

namespace Domains\Customer\Events\Carts;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

abstract class ProductQuantityEvent extends ShouldBeStored
{
    public function __construct(
        public int $cartItemID,
        public int $cartID,
        public int $quantity
    ) {
    }
}
