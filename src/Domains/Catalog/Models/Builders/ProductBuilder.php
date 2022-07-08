<?php

declare(strict_types=1);

namespace Domains\Catalog\Models\Builders;

use Domains\Shared\Models\Builders\HasActiveScope;
use Illuminate\Database\Eloquent\Builder;

class ProductBuilder extends Builder
{
    use HasActiveScope;
}
