<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  
    public function up(): void {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column: 'name');
            $table->mediumText(column: 'description');

            $table->unsignedBigInteger(column:'cost');  
            $table->unsignedBigInteger(column:'retail');
            $table->unsignedInteger(column:'quantity');

            $table->morphs(name:'purchasable');
            $table->foreignId(column: 'order_id')
                ->index()
                ->nullable()
                ->constrained()
                ->nullOnDelete()
            ;

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_lines');
    }
};
