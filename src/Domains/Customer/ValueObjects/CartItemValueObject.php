<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

/**
 * @template TKey
 * @template TValue
 */
class CartItemValueObject
{
  /**
   * [Description for __construct]
   *
   * @param  public int $purchasableID
   * @param  public string $purchasableType
   *
   */
    public function __construct(
        public int $purchasableID,
        public string $purchasableType
    ) {
    }

    /**
     * @return array<TKey,TValue>
     */
    public function toArray(): array
    {
        return [
      'purchasable_id' => $this->purchasableID,
      'purchasable_type' => $this->purchasableType
    ];
    }
}
