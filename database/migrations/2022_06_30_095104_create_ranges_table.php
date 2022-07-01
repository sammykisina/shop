<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  
    public function up(): void {
        Schema::create('ranges', function (Blueprint $table) {
            $table->id();
            $table->uuid(column:'uuid')->unique();

            $table->string(column:'name');
            $table->mediumText(column:'description');
            $table->string(column:'active')->default('true');
        });
    }

    public function down(): void {
        Schema::dropIfExists('ranges');
    }
};