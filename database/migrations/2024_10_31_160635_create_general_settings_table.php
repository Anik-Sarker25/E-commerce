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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_motto')->nullable();
            $table->string('about_company')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('admin_logo')->nullable();
            $table->string('copyright')->nullable();
            $table->string('site_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            $table->text('map')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
