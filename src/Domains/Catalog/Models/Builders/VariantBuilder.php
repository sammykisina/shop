<?php

declare(strict_types=1);

namespace Domains\Catalog\Models\Builders;

use Domains\Shared\Models\Builders\HasActiveScope;
use Illuminate\Database\Eloquent\Builder;

class VariantBuilder extends Builder {
  use HasActiveScope;

  public function physical(): self {
    return $this->where(column:'shippable', operator: true);
  }
  
  public function digital(): self {
   return $this->where(column:'shippable', operator: true);
  }

  public function downloadable(): self {
    return $this->digital();
  }
}