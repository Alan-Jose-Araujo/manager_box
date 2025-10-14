<?php

namespace Database\Seeders\Clients;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clients\User;
use App\Models\Clients\Company;

class UserSeeder extends Seeder
{
    public function run(): void
    {
       $companies = Company::all(); 

      $companies->each(function($company) {
        User::factory()->for($company)->create();
    });

        $remainingUsers = 10; 
        User::factory()->count($remainingUsers)->make()->each(function($user) use ($companies) {
            $user->company_id = $companies->random()->id;
            $user->save();
        });
    }
}
