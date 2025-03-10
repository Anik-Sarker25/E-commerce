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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('delivery_place')->default(Constant::DELIVERY_PLACE['home']);
            $table->string('address');
            $table->string('upazila');
            $table->string('city');
            $table->string('state');
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('is_default')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
