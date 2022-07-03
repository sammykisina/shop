<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\OrderLineFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model {
  use HasFactory;
  use HasUuid;

  // protected $fillable = [
  //   'uuid',
  //   'name',
  //   'description',
  //   'retail',
  //   'cost',
  //   'quantity',
  //   'purchasable_id',
  //   'purchasable_type'
  // ];

  protected $cast = [
    //
  ];

  protected static function newFactory(): OrderLineFactory {
    return new OrderLineFactory();
  }
}
