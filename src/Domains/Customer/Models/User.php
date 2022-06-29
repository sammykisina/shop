<?php

declare(strict_types=1);

namespace Domains\Customer\Modals;

use Domains\Customer\Models\Address;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasUuid;
    use HasApiTokens; 
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function addresses(): HasMany {
       return  $this->hasMany(
            related: Address::class,
            foreignKey: 'user_id'
       );
    }
}
