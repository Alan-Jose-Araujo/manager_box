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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name');
            $table->string('corporate_name');
            $table->char('cnpj', 14)->unique();
            $table->string('state_registration', 15)->nullable();
            $table->string('logo_picture_path')->nullable();
            $table->char('phone_number', 15)->nullable();
            $table->string('landline_number', 15)->nullable();
            $table->string('contact_email')->unique()->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
