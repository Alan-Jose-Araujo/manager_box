<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\FilteredIndexer;
use App\Models\ItemInStock;
use App\Traits\Traits\DefineFilters;
use Illuminate\Pagination\LengthAwarePaginator;
use LogicException;

class ItemInStockRepository implements FilteredIndexer
{
    use DefineFilters;

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], int $perPage = 15, string|array|callable|null $orderBy = null): LengthAwarePaginator
    {
        $query = ItemInStock::query();
        $this->applyFilters($query, $filters);

        if($orderBy) {

            if(is_string($orderBy)) {
                $query->orderBy($orderBy);
            } else if(is_array($orderBy)) {
                $query->orderBy(...array_values($orderBy));
            } else if(is_callable($orderBy)) {
                $query->orderBy($orderBy());
            }

        }

        return $query->paginate($perPage);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return ItemInStock|\Illuminate\Database\Eloquent\Builder<ItemInStock>
     */
    public function findItemInStockById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?ItemInStock
    {
        return ItemInStock::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array $data
     * @return ItemInStock
     */
    public function createItemInStock(array $data): ItemInStock
    {
        return ItemInStock::create($data);
    }

    /**
     * @param \App\Models\ItemInStock $itemInStock
     * @param array $data
     * @return ItemInStock
     */
    public function updateItemInStock(ItemInStock $itemInStock, array $data): ItemInStock
    {
        $itemInStock->update($data);
        return $itemInStock;
    }

    /**
     * @param \App\Models\ItemInStock $itemInStock
     * @return bool
     */
    public function softDeleteItemInStock(ItemInStock $itemInStock): bool
    {
        return (bool) $itemInStock->delete();
    }

    /**
     * @param \App\Models\ItemInStock $itemInStock
     * @return bool
     */
    public function forceDeleteItemInStock(ItemInStock $itemInStock): bool
    {
        return (bool) $itemInStock->forceDelete();
    }

    /**
     * @param \App\Models\ItemInStock $itemInStock
     * @throws \LogicException
     * @return bool
     */
    public function restoreItemInStock(ItemInStock $itemInStock): bool
    {
        if ($itemInStock->deleted_at === null) {
            throw new LogicException('Cannot restore a item in stock that is not soft-deleted.');
        }
        return (bool) $itemInStock->restore();
    }
}
