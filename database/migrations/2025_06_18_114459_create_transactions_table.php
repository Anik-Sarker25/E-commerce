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
       Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->string('payment_method', 50);           // e.g., cash, sslcommerz
            $table->string('transaction_type', 20);          // e.g., credit, debit
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->nullable();
            $table->string('transaction_status', 20);        // e.g., pending, completed
            $table->string('transaction_id')->nullable();    // Gateway or external ID
            $table->json('gateway_response')->nullable();    // Store full gateway response
            $table->text('remarks')->nullable();             // Optional notes
            $table->ipAddress('ip_address')->nullable();     // Track user's IP
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
