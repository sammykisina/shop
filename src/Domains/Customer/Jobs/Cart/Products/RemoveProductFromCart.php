<?php

declare(strict_types=1);

namespace Domains\Customer\Jobs\Cart\Products;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveProductFromCart implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * [Description for __construct]
     *
     * @param  public Cart $cart
     * @param  public CartItem $item
     *
     */
    public function __construct(
        public Cart $cart,
        public CartItem $item
    ) {
    }

    public function handle(): void
    {
        CartAggregate::retrieve($this->cart->uuid)
        ->removeProductFromCart(
            purchasableID: $this->item->purchasable_id,
            purchasableType: $this->item->purchasable_type,
            cartID: $this->cart->id
        )->persist();
    }
}
