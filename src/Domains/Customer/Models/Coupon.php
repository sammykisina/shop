<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CouponFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
  use HasFactory;
  use HasUuid;

  protected $fillable = [
    'uuid',
    'code',
    'reduction',
    'uses',
    'max_uses',
    'active'
  ];

  protected $cast = [
    'active' => 'boolean'
  ];

  protected static function newFactory(): CouponFactory {
    return new CouponFactory();
  }
}
