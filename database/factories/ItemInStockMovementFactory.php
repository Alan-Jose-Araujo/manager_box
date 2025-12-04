<?php

namespace Database\Factories;

use App\Enums\StockMovementType;
use App\Models\Company;
use App\Models\ItemInStock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemInStockMovement>
 */
class ItemInStockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movement_type' => fake()->randomElement(collect(StockMovementType::cases())->pluck('value')->toArray()),
            'quantity_moved' => fake()->randomNumber(3),
            'company_id' => Company::factory(),
            'item_in_stock_id' => ItemInStock::factory(),
        ];
    }
}
