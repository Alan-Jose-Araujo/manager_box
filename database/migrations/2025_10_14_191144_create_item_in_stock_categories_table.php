<?php

use App\Enums\ItemInStockCategoryScope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_in_stock_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum(
                'scope',
                collect(ItemInStockCategoryScope::cases())->pluck('value')->toArray()
            );
            $table->char('color_hex_code', 7)->nullable()->comment('e.g. #FFFFFF for white color');
            $table->boolean('is_active')->default(true);
            $table->foreignId('company_id')
                ->constrained('companies', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('warehouse_id')
                ->nullable()
                ->constrained('warehouses', 'id')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->index([
                'is_active',
                'name',
            ]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_in_stock_categories');
    }
};
