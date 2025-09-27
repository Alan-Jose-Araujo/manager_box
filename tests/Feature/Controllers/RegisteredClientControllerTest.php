<?php

namespace Tests\Feature\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCreateANewRegisteredClientWithSameAddressData(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $userData = User::factory()->make()->toArray();
        $userData['password'] = 'password';
        $userAddressData = Address::factory()->make()->toArray();
        $userAddressData['company_same_user_address'] = true;

        $response = $this->post('/register', [
            'company' => $companyData,
            'user' => $userData,
            'user_address' => $userAddressData,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('companies', ['cnpj' => $companyData['cnpj']]);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
        $this->assertDatabaseHas('addresses', [
            'building_number' => $userAddressData['building_number'],
            'addressable_type' => User::class,
        ]);
        $this->assertDatabaseHas('addresses', [
            'building_number' => $userAddressData['building_number'],
            'addressable_type' => Company::class,
        ]);
    }

    public function testItCanCreateANewRegisteredClientWithoutSameAddressData(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $userData = User::factory()->make()->toArray();
        $userData['password'] = 'password';
        $userAddressData = Address::factory()->make()->toArray();
        $userAddressData['company_same_user_address'] = false;
        $companyAddressData = Address::factory()->make()->toArray();

        $response = $this->post('/register', [
            'company' => $companyData,
            'user' => $userData,
            'user_address' => $userAddressData,
            'company_address' => $companyAddressData,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('companies', ['cnpj' => $companyData['cnpj']]);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
        $this->assertDatabaseHas('addresses', [
            'building_number' => $userAddressData['building_number'],
            'addressable_type' => User::class,
        ]);
        $this->assertDatabaseHas('addresses', [
            'building_number' => $companyAddressData['building_number'],
            'addressable_type' => Company::class,
        ]);
    }
}
