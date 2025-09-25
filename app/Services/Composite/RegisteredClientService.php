<?php

namespace App\Services\Composite;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Models\Company;
use App\Models\User;
use App\Services\AddressService;
use App\Services\CompanyService;
use App\Services\UserService;
use DB;
use InvalidArgumentException;

class RegisteredClientService
{
    private CompanyService $companyService;

    private UserService $userService;

    private AddressService $addressService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
        $this->userService = new UserService();
        $this->addressService = new AddressService();
    }

    public function create(array $data): RegisteredClientCompositeDto
    {
        $companyData = $data['company'];
        $userData = $data['user'];
        $userAddressData = $data['user_address'];
        $companyAddressData = $data['company_address'] ?? [];

        // TODO: Adjust this condition.
        $useSameAddress = $userAddressData['company_same_user_address'];

        return DB::transaction(function () use ($companyData, $userData, $userAddressData, $companyAddressData, $useSameAddress): RegisteredClientCompositeDto {
            $company = $this->companyService->create($companyData);
            $userData['company_id'] = $company->id;
            $user = $this->userService->create($userData);

            $userAddressData['addressable_type'] = User::class;
            $userAddressData['addressable_id'] = $user->id;
            $userAddress = $this->addressService->create($userAddressData);

            if ($useSameAddress) {
                $addressFields = collect($userAddress->getAttributes())
                    ->only(['street', 'building_number', 'neighborhood', 'city', 'state'])
                    ->toArray();
                $addressFields['addressable_type'] = Company::class;
                $addressFields['addressable_id'] = $company->id;
                $companyAddress = $this->addressService->create($addressFields);
            } else {
                $companyAddressData['addressable_type'] = Company::class;
                $companyAddressData['addressable_id'] = $company->id;
                $companyAddress = $this->addressService->create($companyAddressData);
            }

            //TODO: Assign 'company_admin' permission to the user here if needed

            return new RegisteredClientCompositeDto(
                $company,
                $user,
                $userAddress,
                $companyAddress
            );
        }, 3);
    }
}
