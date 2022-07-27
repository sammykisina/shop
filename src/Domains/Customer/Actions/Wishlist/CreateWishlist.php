<?php

declare(strict_types=1);

namespace Domains\Customer\Actions\Wishlist;

use Domains\Customer\Models\Wishlist;
use Domains\Customer\ValueObjects\WishlistValueObject;
use Illuminate\Database\Eloquent\Model;

class CreateWishlist
{
  public static function handle(WishlistValueObject $wishlistValueObject): Model 
  {
    return Wishlist::query()->create([
      'name' => $wishlistValueObject->name,
      'public' => $wishlistValueObject->public,
      'user_id' => $wishlistValueObject->user_id
    ]);
  }
}