<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid(column:'uuid')->unique();

            $table->string(column:'name');
            $table->mediumText('description');
            $table->unsignedInteger(column:'cost');
            $table->unsignedInteger(column:'retail');
            $table->boolean(column:'active')->default(true);
            $table->boolean(column:'vat')->default(config(key:'shop.vat'));

            $table->foreignId('category_id')
                ->nullable()
                ->index()
                ->constrained()
                ->nullOnDelete()
            ;
            $table->foreignId('range_id')
                ->nullable()
                ->index()
                ->constrained()
                ->nullOnDelete()
            ;

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
