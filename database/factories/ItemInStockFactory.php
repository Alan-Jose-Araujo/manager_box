<?php

namespace Database\Factories;

use App\Enums\ItemInStockUnityOfMeasure;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemInStock>
 */
class ItemInStockFactory extends Factory
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
            'trade_name' => fake()->word(),
            'description' => fake()->text(),
            'sku' => fake()->unique()->numerify('SKU-########'),
            'unity_of_measure' => fake()->randomElement(
                collect(ItemInStockUnityOfMeasure::cases())->pluck('value')->toArray()
            ),
            'quantity' => fake()->randomFloat(2, 0, 1000),
            'minimum_quantity' => fake()->randomFloat(2, 0, 1000),
            'maximum_quantity' => fake()->randomFloat(2, 0, 1000),
            'cost_price' => fake()->randomFloat(2, 1, 1000),
            'sale_price' => fake()->randomFloat(2, 0, 1000),
            'is_active' => true,
            'company_id' => Company::first()->id,
            'brand_id' => Brand::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
