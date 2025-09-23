<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Models\Address;

class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct()
    {
        $this->addressRepository = new AddressRepository();
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Address|\Illuminate\Database\Eloquent\Builder<Address>
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Address
    {
        return $this->addressRepository->findAddressById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return Address
     */
    public function create(array $data): Address
    {
        return $this->addressRepository->createAddress($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Address|null
     */
    public function update(int $id, array $data): ?Address
    {
        $address = $this->addressRepository->findAddressById($id);
        if (!$address) {
            return null;
        }
        return $this->addressRepository->updateCompany($address, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {
        $address = $this->addressRepository->findAddressById($id);
        if (!$address) {
            return false;
        }
        return $this->addressRepository->softDeleteAddress($address);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $address = $this->addressRepository->findAddressById($id, true);
        if (!$address) {
            return false;
        }
        return $this->addressRepository->forceDeleteAddress($address);
    }
}
