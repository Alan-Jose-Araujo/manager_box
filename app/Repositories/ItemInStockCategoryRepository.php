<?php

namespace App\Repositories;

use App\Interfaces\FilteredIndexer;
use App\Models\ItemInStockCategory;
use App\Traits\Traits\DefineFilters;
use Illuminate\Pagination\LengthAwarePaginator;
use LogicException;

class ItemInStockCategoryRepository implements FilteredIndexer
{
    use DefineFilters;

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ItemInStockCategory::query();
        $this->applyFilters($query, $filters);
        return $query->paginate($perPage);
    }


    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return ItemInStockCategory|\Illuminate\Database\Eloquent\Builder<ItemInStockCategory>
     */
    public function findItemInStockCategoryById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?ItemInStockCategory
    {
        return ItemInStockCategory::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array $data
     * @return ItemInStockCategory
     */
    public function createItemInStockCategory(array $data): ItemInStockCategory
    {
        return ItemInStockCategory::create($data);
    }

    /**
     * @param \App\Models\ItemInStockCategory $itemInStockCategory
     * @param array $data
     * @return ItemInStockCategory
     */
    public function updateItemInStockCategory(ItemInStockCategory $itemInStockCategory, array $data): ItemInStockCategory
    {
        $itemInStockCategory->update($data);
        return $itemInStockCategory;
    }

    /**
     * @param \App\Models\ItemInStockCategory $itemInStockCategory
     * @return bool
     */
    public function softDeleteItemInStockCategory(ItemInStockCategory $itemInStockCategory): bool
    {
        return (bool) $itemInStockCategory->delete();
    }

    /**
     * @param \App\Models\ItemInStockCategory $itemInStockCategory
     * @return bool
     */
    public function forceDeleteItemInStockCategory(ItemInStockCategory $itemInStockCategory): bool
    {
        return (bool) $itemInStockCategory->forceDelete();
    }

    /**
     * @param \App\Models\ItemInStockCategory $itemInStockCategory
     * @throws \LogicException
     * @return bool
     */
    public function restoreItemInStockCategory(ItemInStockCategory $itemInStockCategory): bool
    {
        if ($itemInStockCategory->deleted_at === null) {
            throw new LogicException('Cannot restore a item in stock category that is not soft-deleted.');
        }
        return (bool) $itemInStockCategory->restore();
    }
}
