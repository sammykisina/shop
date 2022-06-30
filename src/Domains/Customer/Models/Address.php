<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\AddressFactory;
use Domains\Customer\Modals\User;
use Domains\Customer\Modals\location;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model {
    use HasUuid;
    use HasFactory;

    protected $fillable = [
        'label',
        'billing',
        'user_id',
        'location_id'
    ];

    protected $casts = [
        'billing' => 'boolean'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id'
        );
    }

    public function location(): BelongsTo {
       return $this->belongsTo(
            related: Location::class,
            foreignKey: 'location_id'
       );
    }

    public static function newFactory(): AddressFactory {
       return new AddressFactory();
    }

}
