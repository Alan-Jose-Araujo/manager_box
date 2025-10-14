<?php

namespace Database\Seeders\Stocks;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stocks\ItemInStock;
use App\Models\Clients\Company;

class ItemInStockSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        $companies->each(function ($company) {
            $company->warehouses->each(function ($warehouse) use ($company) {
                $categories = $company->itemInStockCategories;

                ItemInStock::factory()
                    ->count(4)
                    ->create([
                        'company_id' => $company->id,
                        'warehouse_id' => $warehouse->id,
                        'item_in_stock_category_id' => $categories->random()->id,
                    ]);
            });
        });
    }
}
