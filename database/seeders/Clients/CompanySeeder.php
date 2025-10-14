<?php

namespace Database\Seeders\Clients;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clients\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->count(6)->create();
    }
}
