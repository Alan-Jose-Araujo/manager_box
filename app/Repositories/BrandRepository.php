<?php

namespace App\Repositories;

use App\Interfaces\FilteredIndexer;
use App\Models\Brand;
use App\Traits\Traits\DefineFilters;
use Illuminate\Pagination\LengthAwarePaginator;
use LogicException;

class BrandRepository implements FilteredIndexer
{
    use DefineFilters;

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Brand::query();
        $this->applyFilters($query, $filters);
        return $query->paginate($perPage);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Brand|\Illuminate\Database\Eloquent\Builder<Brand>
     */
    public function findBrandById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Brand
    {
        return Brand::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array $data
     * @return Brand
     */
    public function createBrand(array $data): Brand
    {
        return Brand::create($data);
    }

    /**
     * @param \App\Models\Brand $warehouse
     * @param array $data
     * @return Brand
     */
    public function updateBrand(Brand $warehouse, array $data): Brand
    {
        $warehouse->update($data);
        return $warehouse;
    }

    /**
     * @param \App\Models\Brand $warehouse
     * @return bool
     */
    public function softDeleteBrand(Brand $warehouse): bool
    {
        return (bool) $warehouse->delete();
    }

    /**
     * @param \App\Models\Brand $warehouse
     * @return bool
     */
    public function forceDeleteBrand(Brand $warehouse): bool
    {
        return (bool) $warehouse->forceDelete();
    }

    /**
     * @param \App\Models\Brand $warehouse
     * @throws \LogicException
     * @return bool
     */
    public function restoreBrand(Brand $warehouse): bool
    {
        if($warehouse->deleted_at === null) {
            throw new LogicException('Cannot restore a warehouse that is not soft-deleted.');
        }
        return (bool) $warehouse->restore();
    }
}
