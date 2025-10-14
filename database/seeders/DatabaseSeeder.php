<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Clients\CompanySeeder::class,          
            \Database\Seeders\Clients\UserSeeder::class,              
            \Database\Seeders\Stocks\WarehouseSeeder::class,          
            \Database\Seeders\Clients\AddressSeeder::class,           
            \Database\Seeders\Stocks\ItemInStockCategorySeeder::class,
            \Database\Seeders\Stocks\ItemInStockSeeder::class,       
        ]);
    }
}
