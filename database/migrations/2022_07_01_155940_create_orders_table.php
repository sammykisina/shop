<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column: 'number')->unique();
            $table->string(column:'status');
            $table->string(column: 'coupon')->nullable();

            $table->string(column:'intent_id')
                ->comment('Intent Id Is The Payment Intent From Stripe.')
                ->nullable()->unique();

            $table->unsignedBigInteger(column: 'total')->default(0);
            $table->unsignedBigInteger(column: 'reduction')->default(0);

            $table->foreignId(column: 'user_id')
                ->index()
                ->nullable()
                ->constrained()
                ->nullOnDelete()
            ;
            $table->foreignId(column: 'shipping_id')
                ->index()
                ->nullable()
                ->constrained(table:'locations')
                ->nullOnDelete()
            ;
            $table->foreignId(column: 'billing_id')
                ->index()
                ->nullable()
                ->constrained(table: 'locations')
                ->nullOnDelete()
            ;

            $table->timestamp(column: 'completed_at')->nullable();
            $table->timestamp(column: 'cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
