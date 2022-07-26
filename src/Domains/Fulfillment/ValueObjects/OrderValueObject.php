<?php

declare(strict_types=1);

namespace Domains\Fulfillment\ValueObjects;

class OrderValueObject
{
    /**
     * [Description for __construct]
     *
     * @param  public string $cart
     * @param  public int $shipping
     * @param  public int $billing
     *
     */
    public function __construct(
        public string $cart,
        public int $shipping,
        public int $billing,
        public null|string $intent
    ) {
    }
}
