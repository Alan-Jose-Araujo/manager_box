<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
    }

    // TODO: Adapt to an appropriate response.
    public function update(Request $request)
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
}
