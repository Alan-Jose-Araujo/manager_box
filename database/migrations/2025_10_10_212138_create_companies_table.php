<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Empresas // 
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name', 255);
            $table->string('corporate_name', 255)->unique();
            $table->char('cnpj', 14)->unique();
            $table->string('state_registration', 15)->nullable();
            $table->string('logo_picture', 255)->nullable();
            $table->char('phone_number', 15)->nullable();
            $table->char('landline_number', 15)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('website_url', 300)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('fantasy_name');
            $table->index('cnpj');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
