<?php

namespace Database\Factories\Stocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stocks\ItemInStockCategory;


class ItemInStockCategoryFactory extends Factory
{
    protected $model = ItemInStockCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
            'Bebidas', 'Alimentos', 'Limpeza', 'Higiene Pessoal', 
            'Material de Escritório', 'Ferramentas', 'Eletrônicos', 
            'Móveis', 'Produtos Químicos', 'Papelaria']),
            'description' => $this->faker->sentence(),
            'scope' => $this->faker->randomElement(['GLOBAL', 'WAREHOUSE']),
            'color_hex_code' => $this->faker->hexColor(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
