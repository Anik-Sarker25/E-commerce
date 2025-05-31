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
        Schema::create('delivery_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('vehicle_number')->nullable();
            $table->string('image')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('address')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->boolean('active')->default(true);
            $table->tinyinteger('status')->default(Constant::AGENT_STATUS['free']); // engage or free
            $table->foreignId('order_id')->nullable()->constrained('invoices')->onDelete('set null'); // agent is engaged with this order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_agents');
    }
};
