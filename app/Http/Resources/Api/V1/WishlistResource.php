<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource 
{
    public function toArray($request): array 
    {
        return[
            'id' => $this->uuid,
            'type' => 'wishlist',
            'attributes' => [
                'name' => $this->name,
                'public' => $this->public
            ]
        ];
    }
}
