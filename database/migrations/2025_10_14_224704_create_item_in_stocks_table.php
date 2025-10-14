<?php

use App\Enums\ItemInStockUnityOfMeasure;
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
        Schema::create('item_in_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trade_name')->nullable();
            $table->text('description')->nullable();
            $table->string('sku', 50)->unique()->nullable();
            $table->enum(
                'unity_of_measure',
                collect(ItemInStockUnityOfMeasure::cases())->pluck('value')->toArray()
            )->default(ItemInStockUnityOfMeasure::UNIDADE->value);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('minimum_quantity', 10, 2)->default(0);
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('company_id')
            ->constrained('companies', 'id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('warehouse_id')
            ->constrained('warehouses', 'id')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
            $table->index([
                'is_active',
                'name'
            ]);
            $table->index('sku');
            $table->index('unity_of_measure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_in_stocks');
    }
};
