<?php

namespace App\Services;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

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
    public function authenticateWithUser(Authenticatable $user, bool $remember = false): void
    {
        Auth::login($user, $remember);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
