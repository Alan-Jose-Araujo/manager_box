<?php

namespace App\Http\Controllers;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Services\Composite\RegisteredClientService;
use App\Traits\Traits\ExtractData;
use Illuminate\Http\Request;
use Log;

class RegisteredClientController extends Controller
{
    use ExtractData;

    private RegisteredClientService $registeredClientService;

    public function __construct()
    {
        $this->registeredClientService = new RegisteredClientService();
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $companyData = array_filter(
                $data,
                fn($key) => str_starts_with($key, 'company_data_'),
                ARRAY_FILTER_USE_KEY
            );

            $userData = array_filter(
                $data,
                fn($key) => str_starts_with($key, 'user_data_'),
                ARRAY_FILTER_USE_KEY
            );

            $userAddressData = array_filter(
                $data,
                fn($key) => str_starts_with($key, 'user_address_data_'),
                ARRAY_FILTER_USE_KEY
            );

            $companyAddressData = array_filter(
                $data,
                fn($key) => str_starts_with($key, 'company_address_data_'),
                ARRAY_FILTER_USE_KEY
            );

            $registeredClient = $this->registeredClientService->create([
                'company' => $this->replaceArrayKeysFragment($companyData, 'company_data_'),
                'user' => $this->replaceArrayKeysFragment($userData, 'user_data_'),
                'user_address' => $this->replaceArrayKeysFragment($userAddressData, 'user_address_data_'),
                'company_address' => $this->replaceArrayKeysFragment($companyAddressData, 'company_address_data_'),
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
    // ...existing code...
}
