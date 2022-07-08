<?php

declare(strict_types=1);

namespace Domains\Customer\Jobs\Cart\Products;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductQuantity implements ShouldQueue {
    use Dispatchable; 
    use InteractsWithQueue; 
    use Queueable; 
    use SerializesModels;

    
    /**
     * [Description for __construct]
     *
     * @param  public  Cart $cart
     * @param  public  CartItem $cartItem
     * @param  public  int $quantity
     * 
     */
    public function __construct(
        public Cart $cart,
        public CartItem $item,
        public int $quantity = 0
    ){}

    public function handle(): void {
        $aggregate = CartAggregate::retrieve(
            uuid: $this->cart->uuid
        );

        match(true) {
            $this->quantity === 0 => $aggregate->removeProductFromCart(
                purchasableID: $this->item->purchasable_id,
                purchasableType: $this->item->purchasable_type,
                cartID: $this->cart->id,
            )->persist(),

            $this->quantity > $this->item->quantity => $aggregate->increaseProductQuantityInCart(
                cartItemID: $this->item->id,
                cartID: $this->cart->id,
                quantity: $this->quantity
            )->persist(),


            $this->quantity < $this->item->quantity => $aggregate->decreaseProductQuantityInCart(
                cartItemID: $this->item->id,
                cartID: $this->cart->id,
                quantity: $this->quantity
            )->persist()
        };
        
    }
}
