<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\Cart\Coupons\ApplyCoupon;
use Domains\Customer\Actions\Cart\Products\AddProductToCart;
use Domains\Customer\Actions\Cart\Products\RemoveProductFromCart;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;
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
        AddProductToCart::handle(
            purchasableID: $event->purchasableID,
            purchasableType: $event->purchasableType,
            cart: $cart,
        );
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
    ->where(
        column: 'cart_id',
        value: $event->cartID
    )
    ->where(
        column: 'id',
        value: $event->cartItemID
    )->first();

        $cartItem->update(values: [
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
    ->where(
        column: 'cart_id',
        value: $event->cartID
    )
    ->where(
        column: 'id',
        value: $event->cartItemID
    )->first();

        if ($event->quantity >= $cartItem->quantity) {
            CartAggregate::retrieve(
                uuid: Str::uuid()->toString()
            )->removeProductFromCart(
          purchasableID: $cartItem->purchasable_id,
          purchasableType: $cartItem->purchasable_type,
          cartID: $event->cartID,
      );

            return;
        }

        $cartItem->update(values: [
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
