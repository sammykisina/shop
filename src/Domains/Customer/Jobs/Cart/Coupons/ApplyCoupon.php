<?php

declare(strict_types=1);

namespace Domains\Customer\Jobs\Cart\Coupons;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplyCoupon implements ShouldQueue {
    use Dispatchable; 
    use InteractsWithQueue; 
    use Queueable; 
    use SerializesModels;

    /**
     * [Description for __construct]
     *
     * @param  public Cart $cart
     * @param  public Coupon $coupon
     * 
     */
    public function __construct(
        public Cart $cart,
        public string $code
    ){}

    public function handle(): void {
        CartAggregate::retrieve(
            uuid: $this->cart->uuid
        )->applyCoupon(
            cartID: $this->cart->id,
            code: $this->code
        )->persist();
    }
}
