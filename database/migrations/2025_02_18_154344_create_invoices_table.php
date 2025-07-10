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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->tinyInteger('shipping_address_id')->nullable();
            $table->string('tracking_code')->unique()->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->string('payment_method')->default(Constant::PAYMENT_METHOD['cod']);
            $table->string('payment_status')->default(Constant::PAYMENT_STATUS['unpaid']);
            $table->unsignedBigInteger('delivery_type')->nullable();
            $table->string('estimated_delivery_date')->nullable();
            $table->tinyInteger('status')->default(Constant::ORDER_STATUS['pending']);
            $table->string('cancelled_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
