<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();

            $table->string(column:'label'); // House/Office/Head Office/Mums House

            $table->boolean(column:'billing')->default(false);

            $table->foreignId(column:'user_id')->index();
            $table->foreignId(column:'location_id')->index();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('addresses');
    }
};
