<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Customer\Events\Carts\CouponWasApplied;
use Domains\Customer\Events\Carts\ProductQuantityWasDecreased;
use Domains\Customer\Events\Carts\ProductQuantityWasIncreased;
use Domains\Customer\Events\Carts\ProductWasAddedToCart;
use Domains\Customer\Events\Carts\ProductWasRemovedFromCart;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregate extends AggregateRoot
{
    /**
     * [Description for addProductToCart]
     *
     * @param int $purchasableID
     * @param int $cartID
     * @param string $purchasableType
     *
     * @return self
     *
     */
    public function addProductToCart(int $purchasableID, int $cartID, string $purchasableType): self
    {
        $this->recordThat(
            domainEvent: new ProductWasAddedToCart(
                purchasableID: $purchasableID,
                cartID: $cartID,
                purchasableType: $purchasableType
            )
        );

        return $this;
    }

    /**
     * [Description for removeProductFromCart]
     *
     * @param int $purchasableID
     * @param string $purchasableType
     * @param int $cartID
     *
     * @return self
     *
     */
    public function removeProductFromCart(int $purchasableID, string $purchasableType, int $cartID): self
    {
        $this->recordThat(
            domainEvent: new ProductWasRemovedFromCart(
                purchasableID: $purchasableID,
                purchasableType: $purchasableType,
                cartID:$cartID,
            )
        );

        return $this;
    }

    /**
     * [Description for increaseProductQuantityInCart]
     *
     * @param int $cartItemID
     * @param int $cartID
     * @param int $quantity
     *
     * @return self
     *
     */
    public function increaseProductQuantityInCart(int $cartItemID, int $cartID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new ProductQuantityWasIncreased(
                cartItemID: $cartItemID,
                cartID: $cartID,
                quantity: $quantity
            )
        );
        return $this;
    }

    /**
     * [Description for decreaseProductQuantityInCart]
     *
     * @param int $cartItemID
     * @param int $cartID
     * @param int $quantity
     *
     * @return self
     *
     */
    public function decreaseProductQuantityInCart(int $cartItemID, int $cartID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new ProductQuantityWasDecreased(
                cartItemID: $cartItemID,
                cartID: $cartID,
                quantity: $quantity
            )
        );
        return $this;
    }

    /**
     * [Description for applyCoupon]
     *
     * @param int $cartID
     * @param string $code
     *
     * @return self
     *
     */
    public function applyCoupon(int $cartID, string $code): self
    {
        $this->recordThat(
            domainEvent: new CouponWasApplied(
                cartID: $cartID,
                code: $code
            )
        );

        return $this;
    }
}
