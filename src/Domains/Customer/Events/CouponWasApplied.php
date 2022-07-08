<?php

declare(strict_types=1);

namespace Domains\Customer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CouponWasApplied extends ShouldBeStored {
  /**
   * [Description for __construct]
   *
   * @param  public int $cartID
   * @param  public string $code
   * 
   */
  public function __construct(
    public int $cartID,
    public string $code
  ){}
}
