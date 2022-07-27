<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  
    public function up(): void {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->uuid(column: 'uuid')->unique();
            $table->string(column: 'name');

            $table->boolean(column: 'public')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId(column:'user_id')
                ->nullable()->index()->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('wishlists');
    }
};
