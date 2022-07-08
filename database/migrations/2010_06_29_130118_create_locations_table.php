<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column:'house'); // 1234
            $table->string(column:'street'); // Kayole
            $table->string(column:'parish')->nullable(); // Nairobi
            $table->string(column:'ward')->nullable(); // Nairobi South
            $table->string(column:'district')->nullable(); // Kilimani
            $table->string(column:'county')->nullable(); // Nairobi County
            $table->string(column:'postcode'); // 0100
            $table->string(column:'country'); //Kenya

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
