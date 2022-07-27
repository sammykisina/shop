<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

class WishlistValueObject
{
  /**
   * [Description for __construct]
   *
   * @param  public string $name
   * @param null|bool public $public
   * @param null|int public $user_id
   * 
   */

  public function __construct(
    public string $name,
    public null|bool $public = false,
    public null|int $user_id = null
  ){}
  
}
