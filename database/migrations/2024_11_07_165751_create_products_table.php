<?php

use App\Helpers\Constant;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->foreignId('childcategory_id')->nullable()->constrained('child_categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->unsignedBigInteger('delivery_type')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('keywords')->nullable();
            $table->string('item_code')->nullable();
            $table->decimal('buy_price', 10, 0)->nullable()->default(0);
            $table->decimal('mrp_price', 10, 0)->nullable()->default(0);
            $table->decimal('discount_price', 10, 0)->nullable()->default(0);
            $table->decimal('sell_price', 10, 0)->nullable()->default(0);
            $table->string('thumbnail')->nullable();
            $table->longText('description');
            $table->string('return')->nullable();
            $table->string('warranty')->nullable();
            $table->string('unit')->default(Constant::UNIT['pcs']);
            $table->string('deals_time')->nullable();
            $table->tinyInteger('product_type')->nullable();
            $table->tinyInteger('status')->default(Constant::STATUS['active']);
            $table->boolean('has_variants')->default(false);
            $table->timestamps();
            $table->SoftDeletes();
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
