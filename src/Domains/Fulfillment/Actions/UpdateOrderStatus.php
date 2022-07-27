<?php

declare(strict_types=1);

namespace Domains\Fulfillment\Actions;

use Illuminate\Database\Eloquent\Model;

class UpdateOrderStatus
{
  /**
   * [Description for handle]
   *
   * @param Order $order
   * @param string $status
   * 
   * @return void
   * 
   */
  public static function handle(Model $order, string $status): void 
  {
    $order->update([
        'status' => $status
      ]
    );
  }
}
