<?php

namespace Database\Factories\Stocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stocks\Warehouse;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
           'name' => $this->faker->company . ' Warehouse',
            'description' => $this->faker->sentence,
            'is_default' => false,
            'is_active' => true,
        ];
    }
}
