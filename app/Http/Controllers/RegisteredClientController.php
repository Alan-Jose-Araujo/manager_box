<?php

namespace App\Http\Controllers;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Services\Composite\RegisteredClientService;
use Illuminate\Http\Request;
use Log;

class RegisteredClientController extends Controller
{
    private RegisteredClientService $registeredClientService;

    public function __construct()
    {
        $this->registeredClientService = new RegisteredClientService();
    }

    public function store(Request $request)
    {
        try {
            $companyData = $request->input('company');
            $userData = $request->input('user');
            $userAddressData = $request->input('user_address');
            $companyAddressData = $request->input('company_address', []);

            $registeredClient = $this->registeredClientService->create([
                'company' => $companyData,
                'user' => $userData,
                'user_address' => $userAddressData,
                'company_address' => $companyAddressData
            ]);

            if ($registeredClient instanceof RegisteredClientCompositeDto) {
                return response()->json([
                    'success' => true,
                    'client' => $registeredClient,
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
