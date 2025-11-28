<?php

namespace App\Http\Controllers;

use App\Jobs\CreateCompanyDefaultWarehouseJob;
use App\Jobs\DisableRegisteredClientJob;
use App\Services\AuthService;
use App\Services\CompanyService;
use App\Services\Composite\RegisteredClientService;
use App\Traits\ExtractData;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// TODO: Add better exception handling.
class RegisteredClientController extends Controller
{
    use ExtractData;

    private RegisteredClientService $registeredClientService;

    private CompanyService $companyService;

    private AuthService $authService;

    public function __construct()
    {
        $this->registeredClientService = new RegisteredClientService();
        $this->companyService = new CompanyService();
        $this->authService = new AuthService();
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->array('filters');
            $perPage = $request->input('per_page', config('pagination.default_items_per_page'));
            $registeredClients = $this->registeredClientService->index($filters, $perPage);
            return response()->json([
                'success' => true,
                'registered_clients' => $registeredClients
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
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

            CreateCompanyDefaultWarehouseJob::dispatch($registeredClient);

            $request->session()->regenerate();

            $this->authService->authenticateWithUser($registeredClient->user);
            $this->authService->setPostLoginSessionData($registeredClient);

            event(new Registered($registeredClient->user));

            return redirect()->route('dashboard');
        } catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput();
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
