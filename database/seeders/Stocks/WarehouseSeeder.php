<?php

namespace Database\Seeders\Stocks;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stocks\Warehouse;
use App\Models\Clients\Company;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        $companies->each(function($company) {
            Warehouse::factory()->count(2)->for($company)->create();
        });
    }
}
