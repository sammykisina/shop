<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Support;

use Illuminate\Support\Str;

class OrderNumberGenerator
{
  public static function generate() 
  {
    return Str::uuid()->toString();
  }
}
