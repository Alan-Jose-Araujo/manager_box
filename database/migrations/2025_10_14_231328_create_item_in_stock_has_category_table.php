<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_in_stock_has_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('item_in_stock_id')
                ->constrained('items_in_stock', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('item_in_stock_category_id')
                ->constrained('item_in_stock_categories', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_in_stock_has_category');
    }
};
