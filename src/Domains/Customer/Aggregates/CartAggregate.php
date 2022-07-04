<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\ProductQuantityWasDecreased;
use Domains\Customer\Events\ProductQuantityWasIncreased;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregate extends AggregateRoot {
  /**
   * Add A Product (Variant Or Bundle) To Cart
   */
  public function addProductToCart(int $purchasableID,int $cartID):self {
    $this->recordThat(
      domainEvent: new ProductWasAddedToCart(
        purchasableID: $purchasableID,
        cartID: $cartID,
        type: Variant::class
      )
    );
    
    return $this;
  }

  /**
   * Remove A Product From Cart
   */
  public function removeProductFromCart(int $purchasableID, int $cartID,string $type): self {
    $this->recordThat(
      domainEvent: new ProductWasRemovedFromCart(
        purchasableID: $purchasableID,
        cartID: $cartID,
        type: $type
      )
    );

    return $this;
  }

  /**
   * Increase Product Quantity
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
