<?php

namespace App\Services;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    /**
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attemptToAuthenticate(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * @param \Illuminate\Auth\Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function authenticateWithUser(User $user, bool $remember = false): void
    {
        Auth::login($user, $remember);
    }

    public function setPostLoginSessionData(RegisteredClientCompositeDto $registeredClientCompositeDto)
    {
        Session::put([
            'company_id' => $registeredClientCompositeDto->company->id,
        ]);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
