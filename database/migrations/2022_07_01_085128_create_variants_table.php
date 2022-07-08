<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->uuid(column:'uuid')->unique();

            $table->string(column:'name');
            $table->unsignedInteger(column:'cost')->default(0);
            $table->unsignedInteger(column:'retail')->default(0);
            $table->unsignedInteger(column:'height')->nullable();
            $table->unsignedInteger(column:'length')->nullable();
            $table->unsignedInteger(column:'width')->nullable();
            $table->unsignedInteger(column:'weight')->nullable();

            $table->boolean(column:'active')->default(true);
            $table->boolean(column:'shippable')->default(false); // Physical Products

            $table->foreignId(column:'product_id')
                ->nullable()
                ->index()
                ->constrained()
                ->nullOnDelete()
            ;

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
