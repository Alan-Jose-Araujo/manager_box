<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Endereço //
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 180);
            $table->char('building_number', 5);
            $table->string('neighborhood', 180);
            $table->string('city', 150);
            $table->char('state', 2);

            $table->string('addressable_type', 255);
            $table->unsignedBigInteger('addressable_id');
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('state');
            $table->index('city');
            $table->index(['addressable_type', 'addressable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
