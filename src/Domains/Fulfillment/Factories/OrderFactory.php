<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Factories;

use Domains\Fulfillment\ValueObjects\OrderValueObject;

class OrderFactory
{
    /**
     * [Description for make]
     *
     * @param array $attributes
     *
     * @return OrderValueObject
     *
     */
    public static function make(array $attributes): OrderValueObject
    {
        return new OrderValueObject(
            cart: $attributes['cart'],
            shipping: $attributes['shipping'],
            billing: $attributes['billing'],
        );
    }
}
