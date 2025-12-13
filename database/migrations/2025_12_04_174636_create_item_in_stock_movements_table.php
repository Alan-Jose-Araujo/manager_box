<?php

use App\Enums\StockMovementType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_in_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('movement_type', collect(StockMovementType::cases())->pluck('value')->toArray());
            $table->decimal('quantity_moved', 10, 2);
            $table->foreignId('company_id')
            ->constrained('companies', 'id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('item_in_stock_id')
            ->constrained('items_in_stock', 'id')
            ->onUpdate('cascade')
            ->onDelete('no action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_in_stock_movements');
    }
};
