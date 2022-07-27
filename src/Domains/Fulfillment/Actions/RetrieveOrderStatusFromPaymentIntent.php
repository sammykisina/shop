<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Actions;

use Domains\Fulfillment\States\Statuses\OrderStatus;
use Domains\Fulfillment\ValueObjects\PaymentIntentValueObject;
use Spatie\Enum\Laravel\Enum;

class RetrieveOrderStatusFromPaymentIntent
{
  public static function handle(PaymentIntentValueObject $paymentIntent): Enum {
    return match($paymentIntent->status) {
      'succeeded' => OrderStatus::complete(),
      'failed' => OrderStatus::declined(),
      'refunded' => OrderStatus::refunded(),
      default => OrderStatus::pending(),
    };   
  }
}
