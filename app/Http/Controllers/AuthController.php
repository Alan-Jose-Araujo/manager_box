<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// TODO: Return appropriate redirects.
class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only([
                'email',
                'password',
            ]);
            $remember = $request->boolean('remember');

            $result = $this->authService->attemptToAuthenticate($credentials, $remember);

            if (!$result) {
                return redirect()->back()->withErrors([
                    'authetication' => 'Credenciais inválidas.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();

            Session::put('company_id', Auth::user()->company_id);

            return redirect()->route('dashboard');
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
