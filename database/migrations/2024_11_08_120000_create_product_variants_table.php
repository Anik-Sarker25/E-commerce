<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('color_name')->nullable();
            $table->string('color_code')->nullable();
            $table->string('size')->nullable();
            $table->string('storage_capacity')->nullable();
            $table->decimal('buy_price', 10, 0)->nullable()->default(0);
            $table->decimal('mrp_price', 10, 0)->nullable()->default(0);
            $table->decimal('discount_price', 10, 0)->nullable()->default(0);
            $table->decimal('sell_price', 10, 0)->nullable()->default(0);
            $table->integer('stock_quantity')->nullable()->default(0);
            $table->string('color_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
