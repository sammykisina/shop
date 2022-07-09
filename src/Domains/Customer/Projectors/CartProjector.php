<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\Cart\Coupons\ApplyCoupon;
use Domains\Customer\Actions\Cart\Products\AddProductToCart;
use Domains\Customer\Actions\Cart\Products\RemoveProductFromCart;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\Carts\CouponWasApplied;
use Domains\Customer\Events\Carts\ProductQuantityWasDecreased;
use Domains\Customer\Events\Carts\ProductQuantityWasIncreased;
use Domains\Customer\Events\Carts\ProductWasAddedToCart;
use Domains\Customer\Events\Carts\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Database\Eloquent\Model;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Illuminate\Support\Str;

class CartProjector extends Projector
{
  /**
   * [Description for onProductWasAddedToCart]
   *
   * @param ProductWasAddedToCart $event
   *
   * @return void
   *
   */
    public function onProductWasAddedToCart(ProductWasAddedToCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID
        );

        /**
         * Actual Addition Of Product To Cart
         */
        $cartItem = AddProductToCart::handle(
            purchasableID: $event->purchasableID,
            purchasableType: $event->purchasableType,
            cart: $cart,
        );

        /**
         * Update The Cart Total
         */
        $cart->update([
            'total' => ($cart->total + $cartItem->purchasable->retail)
        ]);
    }

    /**
     * [Description for onProductWasRemovedFromCart]
     *
     * @param ProductWasRemovedFromCart $event
     *
     * @return void
     *
     */
    public function onProductWasRemovedFromCart(ProductWasRemovedFromCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID
        );
        
        RemoveProductFromCart::handle(
            purchasableID: $event->purchasableID,
            purchasableType: $event->purchasableType,
            cart: $cart,
        );
    }

    /**
     * [Description for onProductQuantityWasIncreased]
     *
     * @param ProductQuantityWasIncreased $event
     *
     * @return void
     *
     */
    public function onProductQuantityWasIncreased(ProductQuantityWasIncreased $event): void
    {
        $cartItem = CartItem::query()
            ->where('cart_id',$event->cartID)
            ->where('id',$event->cartItemID)
            ->first();

        $cartItem->update([
            'quantity' => ($cartItem->quantity + $event->quantity)
        ]);
    }

    /**
     * [Description for onProductQuantityWasDecreased]
     *
     * @param ProductQuantityWasDecreased $event
     *
     * @return void
     *
     */
    public function onProductQuantityWasDecreased(ProductQuantityWasDecreased $event): void
    {
        $cartItem = CartItem::query()
            ->with(['cart'])
            ->where('cart_id',$event->cartID)
            ->where('id',$event->cartItemID)
            ->first();

        if ($event->quantity >= $cartItem->quantity) {
            CartAggregate::retrieve(
                uuid: $cartItem->cart->uuid
            )->removeProductFromCart(
                purchasableID: $cartItem->purchasable->id,
                purchasableType:  strtolower(class_basename($cartItem->purchasable)),
                cartID: $cartItem->cart->id,
            )->persist();

            return;
        }

        $cartItem->update([
            'quantity' => ($cartItem->quantity - $event->quantity)
        ]);
    }

    /**
     * [Description for onCouponWasApplied]
     *
     * @param CouponWasApplied $event
     *
     * @return void
     *
     */
    public function onCouponWasApplied(CouponWasApplied $event): void
    {
        /**
         * Applied Coupon
         */
        ApplyCoupon::handle(
            cartID: $event->cartID,
            code: $event->code
        );
    }
}
