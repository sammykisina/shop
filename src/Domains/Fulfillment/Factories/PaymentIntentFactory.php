<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Factories;

use Domains\Fulfillment\ValueObjects\PaymentIntentValueObject;
use Stripe\Event;

class PaymentIntentFactory
{
  public static function make(Event $event): PaymentIntentValueObject {
    return new PaymentIntentValueObject(
      id: $event->data->object->id,
      object: $event->data->object->object,
      amount: $event->data->object->amount,
      currency: $event->data->object->currency,
      description: $event->data->object->description,
      status: $event->data->object->status
    );
  }
}
