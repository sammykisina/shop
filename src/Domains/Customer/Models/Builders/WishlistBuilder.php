<?php

declare(strict_types=1);

namespace Domains\Customer\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class WishlistBuilder extends Builder
{
  
  // Get the public wishlists
  public function public() : self 
  {
    return $this->where(column: 'public', operator: true);
  }
}
