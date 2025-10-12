<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    // Authentication tests.

    public function testItCanAuthenticateByCredentialsSuccessfully(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $result = $this->authService->attemptToAuthenticate($credentials);

        $this->assertTrue($result);
        $this->assertAuthenticated('web');
    }

    public function testItCanAuthenticateByUserSuccessfully(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->authService->authenticateWithUser($user);
        $this->assertAuthenticated('web');
    }

    // Authenticated actions tests.
    
    public function testItCanPerformAuthProtectedActions(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->authService->authenticateWithUser($user);
        $this->assertAuthenticated('web');
        
        $authUser = auth()->user();
        $this->assertInstanceOf(User::class, $authUser);
    }

    // Unauthentication tests.

    public function testItCanUnauthenticateSuccessfully(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->authService->authenticateWithUser($user);
        $this->assertAuthenticated('web');

        $this->authService->logout();

        $authUser = auth()->user();
        $this->assertNull($authUser);
    }
}
