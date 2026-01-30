<?php

namespace App\Repositories;

use App\Interfaces\FilteredIndexer;
use App\Models\Address;
use App\Traits\Traits\DefineFilters;
use Illuminate\Pagination\LengthAwarePaginator;
use LogicException;

class AddressRepository implements FilteredIndexer
{
    use DefineFilters;

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Address::query();
        $this->applyFilters($query, $filters);
        return $query->paginate($perPage);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Address|\Illuminate\Database\Eloquent\Builder<Address>
     */
    public function findAddressById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Address
    {
        return Address::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array $data
     * @return Address
     */
    public function createAddress(array $data): Address
    {
        return Address::create($data);
    }

    /**
     * @param \App\Models\Address $address
     * @param array $data
     * @return Address
     */
    public function updateCompany(Address $address, array $data): Address
    {
        $address->update($data);
        return $address;
    }

    /**
     * @param \App\Models\Address $address
     * @return bool
     */
    public function softDeleteAddress(Address $address): bool
    {
        return (bool) $address->delete();
    }

    /**
     * @param \App\Models\Address $address
     * @return bool
     */
    public function forceDeleteAddress(Address $address): bool
    {
        return (bool) $address->forceDelete();
    }

    /**
     * @param \App\Models\Address $address
     * @throws \LogicException
     * @return bool
     */
    public function restoreAddress(Address $address): bool
    {
        if(!$address->deleted_at) {
            throw new LogicException('Cannot restore an address that is not deleted.');
        }
        return (bool) $address->restore();
    }
}
