<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Itens em estoque //
        Schema::create('item_in_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name')->nullable();
            $table->text('description')->nullable();
            $table->string('sku', 50)->nullable();
            $table->enum('unity_of_measure', [
                'AMPOLA','BALDE','BANDEJA','BARRA','BISNAGA','BLOCO','BOBINA','BOMBONA','CAPSULA','CARTELA','CENTO',
                'CONJUNTO','CM','CM2','CAIXA','CAIXA2','CAIXA3','CAIXA5','CAIXA10','CAIXA15','CAIXA20','CAIXA25',
                'CAIXA50','CAIXA100','DISPLAY','DUZIA','EMBALAGEM','FARDO','FOLHA','FRASCO','GALAO','GARRAFA',
                'GRAMAS','JOGO','KG','KIT','LATA','LITRO','M','M2','M3','MILHEIRO','ML','MWH','PACOTE','PALETE',
                'PARES','PECA','POTE','QUILATE','RESMA','ROLO','SACO','SACOLA','TAMBOR','TANQUE','TONELADA',
                'TUBO','UNIDADE','VASILHAME','VIDRO'
            ])->default('UNIDADE');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('minimum_quantity', 10, 2)->default(1);
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreignId('item_in_stock_category_id')->nullable()->constrained('item_in_stock_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    public function down(): void
    {
    Schema::dropIfExists('item_in_stocks');
    }
};
