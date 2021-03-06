<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->morphs(name:'purchasable'); // Can Be A Variant Or A Bundle
            $table->unsignedInteger(column: 'quantity')->default(1);

            $table->foreignId(column:'cart_id')
            ->index()
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
