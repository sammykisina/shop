<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column: 'code');
            $table->unsignedBigInteger(column: 'reduction')->default(0);
            $table->unsignedInteger(column: 'uses')->default(0);
            $table->unsignedInteger(column: 'max_uses')->nullable();
            $table->boolean(column: 'active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
