<?php

declare(strict_types=1);

namespace  Domains\Catalog\Models;

use Database\Factories\RangeFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Range extends Model { // Summer_2022_Conference etc
  use HasFactory;
  use HasUuid;

  public $timestamps = false;

  protected $fillable = [
    'uuid',
    'name',
    'description',
    'active'
  ];

  protected $casts = [ 
    'active' => 'boolean'
  ];

  protected static function newFactory(): RangeFactory {
    return new RangeFactory();
  }
}
