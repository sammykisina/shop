<?php

declare(strict_types=1);

namespace Domains\Customer\Jobs\Cart\Products;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddProductToCart implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    /**
     * [Description for __construct]
     *
     * @param  public CartItemValueObject $cartItem
     * @param  public Cart $cart
     *
     */
    public function __construct(
        public CartItemValueObject $cartItem,
        public Cart $cart
    ) {
    }

    public function handle(): void
    {
        CartAggregate::retrieve(
            $this->cart->uuid
        )->addProductToCart(
            purchasableID: $this->cartItem->purchasableID,
            cartID: $this->cart->id,
            purchasableType: $this->cartItem->purchasableType
        )->persist();
    }
}
