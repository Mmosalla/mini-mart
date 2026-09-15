<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('discount')->default(0);
            $table->longText('short_description')->nullable();
            $table->string('status')->default(\Modules\Product\Enums\ProductEnum::Active->value);
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->unsignedBigInteger('view');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
