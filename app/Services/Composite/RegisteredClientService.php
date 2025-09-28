<?php

namespace App\Services\Composite;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Models\Company;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\CompanyService;
use App\Services\UserService;
use DB;

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

        $userSameAddress = (bool) $userAddressData['company_same_user_address'];

        return DB::transaction(function () use ($companyData, $userData, $userAddressData, $companyAddressData, $userSameAddress): RegisteredClientCompositeDto {
            $company = $this->companyService->create($companyData);
            $userData['company_id'] = $company->id;
            $user = $this->userService->create($userData);

            $userAddressData['addressable_type'] = User::class;
            $userAddressData['addressable_id'] = $user->id;
            $userAddress = $this->addressService->create($userAddressData);

            if ($userSameAddress) {
                $addressFields = collect($userAddress->getAttributes())
                    ->only(['street', 'building_number', 'neighborhood', 'complement', 'city', 'state'])
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

    public function softDelete(int $userId): bool
    {
        $user = $this->userService->find($userId);
        if(!$user) {
            return false;
        }
        //TODO: Check if user has the required roles/permissions.
        $company = $user->company;
        $userAddress = $user->address;
        $companyAddress = $company->address;

        (new AddressRepository())->softDeleteAddress($userAddress);
        (new AddressRepository())->softDeleteAddress($companyAddress);
        
        foreach($company->users as $user) {
            (new UserRepository())->softDeleteUser($user);
        }

        (new CompanyRepository())->softDeleteCompany($company);

        return true;
    }
}
