<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
