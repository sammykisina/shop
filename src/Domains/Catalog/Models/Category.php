<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\CategoryFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model { // T-Shirts, Hats etc
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

  protected static function newFactory(): CategoryFactory {
    return new CategoryFactory();
  }
}
