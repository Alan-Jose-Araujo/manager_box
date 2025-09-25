<?php

namespace App\Dtos\Composite;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;

class RegisteredClientCompositeDto
{
    public Company $company;

    public User $user;

    public Address $userAddress;

    public Address $companyAddress;

    public function __construct(Company $company, User $user, Address $userAddress, Address $companyAddress)
    {
        $this->company = $company;
        $this->user = $user;
        $this->userAddress = $userAddress;
        $this->companyAddress = $companyAddress;
    }
}
