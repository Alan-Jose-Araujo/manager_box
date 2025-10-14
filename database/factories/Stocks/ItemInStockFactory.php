<?php

namespace Database\Factories\Stocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stocks\ItemInStock;

class ItemInStockFactory extends Factory
{
    protected $model = ItemInStock::class;
  
    public function definition(): array
    {
        return [
            'trade_name' => $this->faker->randomElement([
                'Sabão Líquido', 'Detergente', 'Álcool 70%', 'Papel Toalha', 'Desinfetante',
                'Martelo', 'Chave de Fenda', 'Furadeira', 'Parafuso 3mm', 'Trena 5m',
                'Mouse Óptico', 'Teclado Mecânico', 'Monitor LCD 24"', 'Cabo HDMI', 'Carregador USB-C',
                'Caderno Universitário', 'Caneta Azul', 'Lápis HB', 'Pasta Arquivo', 'Envelope A4',
                'Adubo Orgânico', 'Regador Plástico', 'Vaso de Cerâmica', 'Sementes de Manjericão', 'Pá de Jardim']),
            'description' => $this->faker->sentence(),
            'sku' => strtoupper($this->faker->bothify('SKU-####')),
            'unity_of_measure' => $this->faker->randomElement(['AMPOLA','BALDE','BANDEJA','BARRA','BISNAGA','BLOCO','BOBINA','BOMBONA','CAPSULA','CARTELA','CENTO',
            'CONJUNTO','CM','CM2','CAIXA','CAIXA2','CAIXA3','CAIXA5','CAIXA10','CAIXA15','CAIXA20','CAIXA25',
            'CAIXA50','CAIXA100','DISPLAY','DUZIA','EMBALAGEM','FARDO','FOLHA','FRASCO','GALAO','GARRAFA',
            'GRAMAS','JOGO','KG','KIT','LATA','LITRO','M','M2','M3','MILHEIRO','ML','MWH','PACOTE','PALETE',
            'PARES','PECA','POTE','QUILATE','RESMA','ROLO','SACO','SACOLA','TAMBOR','TANQUE','TONELADA',
            'TUBO','UNIDADE','VASILHAME','VIDRO']),
            'quantity' => $this->faker->randomFloat(2, 10, 500),
            'minimum_quantity' => $this->faker->randomFloat(2, 1, 10),
            'cost_price' => $this->faker->randomFloat(2, 10, 100),
            'sale_price' => $this->faker->randomFloat(2, 100, 300),
        ];
    }
}

