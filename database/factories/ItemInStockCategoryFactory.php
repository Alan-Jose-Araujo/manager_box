<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ItemInStockCategoryScope;
use App\Models\Company;
use App\Models\Warehouse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemInStockCategory>
 */
class ItemInStockCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(),
            'scope' => fake()->randomElement(collect(ItemInStockCategoryScope::cases())->pluck('value')->toArray()),
            'color_hex_code' => fake()->optional()->hexColor(),
            'is_active' => true,
            'company_id' => Company::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
