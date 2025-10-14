<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        // Relacionamento itens-categorias //
        Schema::create('item_in_stock_has_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_in_stock_id')->constrained('item_in_stocks')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('item_in_stock_category_id')->constrained('item_in_stock_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_in_stock_has_category');
    }
};
