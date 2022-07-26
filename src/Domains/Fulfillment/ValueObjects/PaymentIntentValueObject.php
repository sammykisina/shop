<?php

declare(strict_types=1);

namespace Domains\Fulfillment\ValueObjects;

class PaymentIntentValueObject
{
  /**
   * [Description for __construct]
   *
   * @param  public string $id
   * @param  public string $object
   * @param  public int $amount
   * @param  public string $currency
   * @param  public string $description
   * @param  public string $status
   * 
   */
  public function __construct(
    public string $id,
    public string $object,
    public int $amount,
    public string $currency,
    public string $description,
    public string $status
   ){}
}
