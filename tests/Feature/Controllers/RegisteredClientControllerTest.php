<?php

namespace Tests\Feature\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use App\Traits\Traits\ExtractData;
use App\Traits\UploadFiles;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisteredClientControllerTest extends TestCase
{
    use RefreshDatabase;
    use UploadFiles;
    use ExtractData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function testItCanCreateANewRegisteredClientWithSameAddressData(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $userData = User::factory()->make()->toArray();
        $userData['password'] = 'password';
        $userAddressData = Address::factory()->make()->toArray();
        $userAddressData['company_same_user_address'] = true;
        $requestPayload = [];

        foreach ($companyData as $key => $value) {
            $requestPayload['company_data_' . $key] = $value;
        }
        foreach ($userData as $key => $value) {
            $requestPayload['user_data_' . $key] = $value;
        }
        foreach ($userAddressData as $key => $value) {
            $requestPayload['user_address_data_' . $key] = $value;
        }

        $response = $this->post('/register', $requestPayload);

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
        $requestPayload = [];

        foreach ($companyData as $key => $value) {
            $requestPayload['company_data_' . $key] = $value;
        }
        foreach ($userData as $key => $value) {
            $requestPayload['user_data_' . $key] = $value;
        }
        foreach ($userAddressData as $key => $value) {
            $requestPayload['user_address_data_' . $key] = $value;
        }
        foreach ($companyAddressData as $key => $value) {
            $requestPayload['company_address_data_' . $key] = $value;
        }

        $response = $this->post('/register', $requestPayload);

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

    public function testItCanCreateANewRegisteredClientWithPicturesFiles(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $companyData['logo_picture_path'] = $this->generateFakeFile([
            'name' => 'logo_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $userData = User::factory()->make()->toArray();
        $userData['profile_picture_path'] = $this->generateFakeFile([
            'name' => 'profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $userData['password'] = 'password';
        $userAddressData = Address::factory()->make()->toArray();
        $userAddressData['company_same_user_address'] = false;
        $companyAddressData = Address::factory()->make()->toArray();
        $requestPayload = [];

        foreach ($companyData as $key => $value) {
            $requestPayload['company_data_' . $key] = $value;
        }
        foreach ($userData as $key => $value) {
            $requestPayload['user_data_' . $key] = $value;
        }
        foreach ($userAddressData as $key => $value) {
            $requestPayload['user_address_data_' . $key] = $value;
        }
        foreach ($companyAddressData as $key => $value) {
            $requestPayload['company_address_data_' . $key] = $value;
        }

        $response = $this->post('/register', $requestPayload);

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
        Storage::disk('public')->deleteDirectory('user_profile_pictures');
    }

    public function testItCanUpdateCompanyWithSession(): void
    {
        $company = Company::factory()->create();
        $companyAdmin = User::factory()->create([
            'company_id' => $company->id,
        ]);
        $newData = [
            'fantasy_name' => 'Updated fantasy name'
        ];

        $this->actingAs($companyAdmin);
        $companyAdmin->assignRole('company_admin');

        $response = $this->withSession([
            'company_id' => $company->id,
        ])->patch('/update-company', $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'fantasy_name' => $newData['fantasy_name'],
        ]);
    }

    public function testItCanDisableRegisteredClient(): void
    {
        $company = Company::factory()->create();
        $companyAdmin = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->actingAs($companyAdmin);
        $companyAdmin->assignRole('company_admin');

        $response = $this->withSession([
            'company_id' => $company->id
        ])->patch('/disable-account');

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'is_active' => false
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $companyAdmin->id,
            'is_active' => false,
        ]);
    }
}