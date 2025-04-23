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
        Schema::create('variant_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color_family')->nullable();
            $table->string('variant_type');
            $table->string('variant_value')->nullable(); // e.g. '64GB', '12 Months', 'Large'
            $table->decimal('buy_price', 10, 0)->nullable()->default(0);
            $table->decimal('mrp_price', 10, 0)->nullable()->default(0);
            $table->decimal('discount_price', 10, 0)->nullable()->default(0);
            $table->decimal('sell_price', 10, 0)->nullable()->default(0);
            $table->integer('stock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_options');
    }
};
