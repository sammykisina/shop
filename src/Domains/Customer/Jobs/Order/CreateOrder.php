<?php

declare(strict_types=1);

namespace Domains\Customer\Jobs\Order;

use Domains\Customer\Aggregates\OrderAggregate;
use Domains\Customer\ValueObjects\OrderValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public OrderValueObject $order,
    ) {
    }

    public function handle(): void
    {
        OrderAggregate::retrieve(
            uuid: Str::uuid()->toString()
        )->createOrder(
            order: $this->order
        )->persist();
    }
}
