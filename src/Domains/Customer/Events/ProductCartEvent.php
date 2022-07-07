<?php

declare(strict_types=1);

namespace Domains\Customer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

abstract class ProductCartEvent  extends ShouldBeStored{
 
  /**
   * [Description for __construct]
   *
   * @param  public int $purchasableID
   * @param  public string $purchasableType
   * @param  public int $cartID
   * 
   */
  public function __construct(
    public int $purchasableID,
    public string $purchasableType,
    public int $cartID,
  ){} 
}
