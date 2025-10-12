<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::createOrFirst([
            'name' => 'global_admin',
        ]);

        Role::createOrFirst([
            'name' => 'company_admin',
        ]);
    }
}
