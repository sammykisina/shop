<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Cart;

use Domains\Customer\Models\Cart;
use Domains\Customer\ValueObjects\CartValueObject;
use Illuminate\Database\Eloquent\Model;

class CreateCart
{
    /**
     * @param CartValueObject $object
     * @return Model
     */
    public static function handle(CartValueObject $cart): Model
    {
        return Cart::query()->create($cart->toArray());
    }
}
