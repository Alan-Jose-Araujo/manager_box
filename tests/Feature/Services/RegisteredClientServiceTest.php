<?php

namespace Tests\Feature\Services;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use App\Services\Composite\RegisteredClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredClientServiceTest extends TestCase
{
    use RefreshDatabase;

    private RegisteredClientService $registeredClientService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registeredClientService = new RegisteredClientService();
    }

    public function testItCanCreateANewRegisteredClientWithCompanyAddress(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $userData = User::factory()->make()->makeVisible('password')->toArray();
        $userAddress = Address::factory()->make()->toArray();
        $companyAddressData = Address::factory()->make()->toArray();
        $userAddress['company_same_user_address'] = false;

        $registeredClient = $this->registeredClientService->create([
            'company' => $companyData,
            'user' => $userData,
            'user_address' => $userAddress,
            'company_address' => $companyAddressData,
        ]);

        $this->assertInstanceOf(RegisteredClientCompositeDto::class, $registeredClient);
        $this->assertInstanceOf(Company::class, $registeredClient->company);
        $this->assertInstanceOf(User::class, $registeredClient->user);
        $this->assertInstanceOf(Address::class, $registeredClient->userAddress);
        $this->assertInstanceOf(Address::class, $registeredClient->companyAddress);
    }

    public function testItCanCreateANewRegisteredClientWithoutCompanyAddress(): void
    {
        $companyData = Company::factory()->make()->toArray();
        $userData = User::factory()->make()->makeVisible('password')->toArray();
        $userAddress = Address::factory()->make()->toArray();
        $userAddress['company_same_user_address'] = true;

        $registeredClient = $this->registeredClientService->create([
            'company' => $companyData,
            'user' => $userData,
            'user_address' => $userAddress,
        ]);

        $this->assertInstanceOf(RegisteredClientCompositeDto::class, $registeredClient);
        $this->assertInstanceOf(Company::class, $registeredClient->company);
        $this->assertInstanceOf(User::class, $registeredClient->user);
        $this->assertInstanceOf(Address::class, $registeredClient->userAddress);
        $this->assertInstanceOf(Address::class, $registeredClient->companyAddress);
    }

    public function testItCanSoftDeleteARegisteredClient(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);
        $userAddress = Address::factory()->create([
            'addressable_type' => User::class,
            'addressable_id' => $user->id,
        ]);
        $companyAddress = Address::factory()->create([
            'addressable_type' => Company::class,
            'addressable_id' => $company->id,
        ]);

        $result = $this->registeredClientService->softDelete($user->id);

        $this->assertTrue($result);
        $this->assertSoftDeleted($user);
        $this->assertSoftDeleted($company);
        $this->assertSoftDeleted($userAddress);
        $this->assertSoftDeleted($companyAddress);
    }
}
