<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\OrderValueObject;

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
            userID: $attributes['userID'],
            email: $attributes['email'],
        );
    }
}
