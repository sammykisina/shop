<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domains\Customer\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
      Location::factory(count:50)->create();
    }
}
