<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\UserFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
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
        'billing_id',
        'shipping_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function defaultShippingAddress(): BelongsTo
    {
        return $this->belongsTo(
            related: Address::class,
            foreignKey:'shipping_id'
        );
    }

    public function defaultBillingAddress(): BelongsTo
    {
        return $this->belongsTo(
            related: Address::class,
            foreignKey:'billing_id'
        );
    }

    public function addresses(): HasMany
    {
        return  $this->hasMany(
            related: Address::class,
            foreignKey: 'user_id'
        );
    }

    public function cart(): HasOne
    {
        return $this->hasOne(
            related: Cart::class,
            foreignKey: 'user_id'
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(
            related: Order::class,
            foreignKey:'user_id'
        );
    }

    public function wishlists():  HasMany {
        return $this->hasMany(
            related: Wishlist::class,
            foreignKey:'user_id'
        );
    }

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }
}
