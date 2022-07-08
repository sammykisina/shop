<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column:'status');// pending (When Adding Or Removing Items From The Cart)/checked-out (When The Cart Goes Through The Payment Cycle And Waiting For Payment Status )/abandoned
            $table->string(column:'coupon')->nullable();
            $table->unsignedBigInteger(column:'total')->default(0);
            $table->unsignedBigInteger(column:'reduction')->default(0);

            $table->foreignId(column: 'user_id')
                ->index()
                ->nullable() // For Guest Users
                ->constrained()
                ->nullOnDelete()
            ;

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
