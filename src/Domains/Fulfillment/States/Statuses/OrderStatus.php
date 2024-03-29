<?php


declare(strict_types=1);

namespace Domains\Fulfillment\States\Statuses;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self pending(),
 * @method static self declined(),
 * @method static self complete(),
 * @method static self refunded(),
 * @method static self cancelled()
 */

final class OrderStatus extends Enum {}
