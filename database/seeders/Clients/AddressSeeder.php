<?php

namespace Database\Seeders\Clients;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clients\Address;
use App\Models\Clients\Company;
use App\Models\Stocks\Warehouse;
use App\Models\Clients\User;

class AddressSeeder extends Seeder
{
    
    public function run(): void
    {
        $companies = Company::all();
        $companies->each(function($company) {
            Address::factory()->for($company, 'addressable')->create();
        });

        $warehouses = Warehouse::all();
        $warehouses->each(function($warehouse) {
            Address::factory()->for($warehouse, 'addressable')->create();
        });

        $users = User::all();
        $users->each(function($user) {
            Address::factory()->for($user, 'addressable')->create();
        });
    }
}
