<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        //Categorias de itens em estoque // 
        Schema::create('item_in_stock_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('scope', ['GLOBAL', 'WAREHOUSE'])->default('GLOBAL');
            $table->char('color_hex_code', 7)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('company_id')->constrained('companies')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
    Schema::dropIfExists('item_in_stock_categories');
    }
};
