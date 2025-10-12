<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Log;

// TODO: Return appropriate redirects.
class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only([
                'email',
                'password',
            ]);
            $remember = $request->boolean('remember');

            $result = $this->authService->attemptToAuthenticate($credentials, $remember);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $this->authService->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        } catch (Exception $exception)
        {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
