<?php

namespace Tests\Feature\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    // Login tests.

    public function testItCanLoginWithoutRememberSucceffuly(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->post('/auth/login', $credentials);
        //TODO: Change it when login view its implemented.
        $response->assertStatus(200);
        $this->assertAuthenticated('web');
    }

    public function testItCanLoginWithRememberSucceffuly(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
            'remember' => true,
        ];

        $response = $this->post('/auth/login', $credentials);
        //TODO: Change it when login view its implemented.
        $response->assertStatus(200);
        $this->assertAuthenticated('web');
    }

    // Authenticated actions tests.

    public function testItCanAccessProtectedRouteSuccessfully(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        (new AuthService())->authenticateWithUser($user);

        $response = $this->get('/auth/test');
        $response->assertStatus(200);
        $this->assertAuthenticated('web');
    }

    // Logout tests.

    public function testItCanLogoutSuccessfully(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        (new AuthService())->authenticateWithUser($user);

        $this->assertAuthenticated('web');
        $response = $this->post('/auth/logout');
        $response->assertRedirect('/');
    }
}
