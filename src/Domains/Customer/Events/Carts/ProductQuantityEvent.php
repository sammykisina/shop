<?php

declare(strict_types=1);

namespace Domains\Customer\Events\Carts;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

abstract class ProductQuantityEvent extends ShouldBeStored
{
    /**
     * [Description for __construct]
     *
     * @param  public int $cartID
     * @param  public int $cartItemID
     * @param  public int $quantity
     * 
     */
    public function __construct(
        public int $cartID,
        public int $cartItemID,
        public int $quantity
    ){}
}
