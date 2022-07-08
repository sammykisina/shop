<?php

declare(strict_types=1);

return [
  'vat' => env(key:'SHOP_VAT', default:false),
  'profit_margin' => env(key:'SHOP_PROFIT_MARGIN', default: 1.4)
];
