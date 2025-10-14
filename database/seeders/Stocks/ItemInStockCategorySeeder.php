<?php

namespace Database\Seeders\Stocks;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stocks\ItemInStockCategory;
use App\Models\Clients\Company;

class ItemInStockCategorySeeder extends Seeder
{
    public function run(): void
    {
         $companies = Company::all();

        $companies->each(function($company) {
            ItemInStockCategory::factory()
                ->count(3) 
                ->create(['company_id' => $company->id]);
        });
    }
}
