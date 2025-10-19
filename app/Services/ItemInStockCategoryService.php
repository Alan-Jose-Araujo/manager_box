<?php

namespace App\Services;

use App\Models\ItemInStockCategory;
use App\Repositories\ItemInStockCategoryRepository;

class ItemInStockCategoryService
{
    private ItemInStockCategoryRepository $itemInStockCategoryRepository;

    public function __construct()
    {
        $this->itemInStockCategoryRepository = new ItemInStockCategoryRepository();
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return ItemInStockCategory|\Illuminate\Database\Eloquent\Builder<ItemInStockCategory>
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?ItemInStockCategory
    {
        return $this->itemInStockCategoryRepository->findItemInStockCategoryById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return ItemInStockCategory
     */
    public function create(array $data): ItemInStockCategory
    {
        return $this->itemInStockCategoryRepository->createItemInStockCategory($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ItemInStockCategory|null
     */
    public function update(int $id, array $data): ?ItemInStockCategory
    {
        $itemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById($id);
        if(!$itemInStockCategory) {
            return null;
        }
        return $this->itemInStockCategoryRepository->updateItemInStockCategory($itemInStockCategory, $data);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return bool
     */
    public function softDelete(int $id, bool $includeTrashed = false, array $columns = ['*']): bool
    {
        $itemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById($id, $includeTrashed, $columns);
        if(!$itemInStockCategory) {
            return false;
        }
        return $this->itemInStockCategoryRepository->softDeleteItemInStockCategory($itemInStockCategory);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $itemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById($id, true);
        if(!$itemInStockCategory) {
            return false;
        }
        return $this->itemInStockCategoryRepository->forceDeleteItemInStockCategory($itemInStockCategory);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $itemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById($id, true);
        if(!$itemInStockCategory) {
            return false;
        }
        return $this->itemInStockCategoryRepository->restoreItemInStockCategory($itemInStockCategory);
    }
}
