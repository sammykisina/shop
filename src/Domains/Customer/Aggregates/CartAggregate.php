<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;


class CartAggregate extends AggregateRoot {
  /**
   * [Description for addProductToCart]
   *
   * @param CartItemValueObject $cartItem
   * @param int $cartID
   * @param string $type
   * 
   * @return self
   * 
   */
  public function addProductToCart(int $purchasableID,int $cartID,string $purchasableType):self {
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
   * @param CartItemValueObject $cartItem
   * @param int $cartID
   * @param string $type
   * 
   * @return self
   * 
   */
  public function removeProductFromCart(int $purchasableID,string $purchasableType, int $cartID ): self {
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
  public function increaseProductQuantityInCart(int $cartItemID, int $cartID, int $quantity): self {
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
   * Decrease Product Quantity
   */
  public function decreaseProductQuantityInCart(int $cartItemID, int $cartID, int $quantity): self {
    $this->recordThat(
      domainEvent: new ProductQuantityWasDecreased(
        cartItemID: $cartItemID,
        cartID: $cartID,
        quantity: $quantity
      )
    );
    return $this;
  }
}
