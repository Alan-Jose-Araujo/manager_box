<?php

namespace App\Http\Controllers;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Jobs\DisableRegisteredClientJob;
use App\Services\CompanyService;
use App\Services\Composite\RegisteredClientService;
use App\Traits\Traits\ExtractData;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

// TODO: Add better exception handling.
class RegisteredClientController extends Controller
{
    use ExtractData;

    private RegisteredClientService $registeredClientService;

    private CompanyService $companyService;

    public function __construct()
    {
        $this->registeredClientService = new RegisteredClientService();
        $this->companyService = new CompanyService();
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

                event(new Registered($registeredClient->user));

                return response()->json([
                    'success' => true,
                    'client' => $registeredClient,
                ]);
            }
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    // TODO: Adapt to an appropriate response.
    public function updateCompany(Request $request)
    {
        try {
            $companyId = Session::get('company_id');
            $newCompanyData = $request->all();
            $updatedCompany = $this->companyService->update($companyId, $newCompanyData);

            if (!$updatedCompany) {
                // TODO: Handle it.
                throw new Exception('The current authenticated company was not found.');
            }

            return response()->json([
                'success' => true,
                'company' => $updatedCompany,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function disable()
    {
        try {
            $companyId = (int) Session::get('company_id');
            $company = $this->companyService->find($companyId);

            if (!$company) {
                throw new Exception('The current authenticated company was not found.');
            }

            DisableRegisteredClientJob::dispatch($company);

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
}
