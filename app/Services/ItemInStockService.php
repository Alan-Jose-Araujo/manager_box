<?php

namespace App\Services;

use App\Models\ItemInStock;
use App\Repositories\ItemInStockRepository;
use App\Traits\UploadFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemInStockService
{
    use UploadFiles;

    private ItemInStockRepository $itemInStockRepository;

    public function __construct()
    {
        $this->itemInStockRepository = new ItemInStockRepository();
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return ItemInStock|\Illuminate\Database\Eloquent\Builder<ItemInStock>
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?ItemInStock
    {
        return $this->itemInStockRepository->findItemInStockById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return ItemInStock
     */
    public function create(array $data): ItemInStock
    {
        if (isset($data['illustration_picture_path']) && $data['illustration_picture_path'] instanceof UploadedFile) {
            $uploadedFile = $data['illustration_picture_path'];
            $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'item_in_stock_illustration_pictures');
            $data['illustration_picture_path'] = $filePath;
        }
        return $this->itemInStockRepository->createItemInStock($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ItemInStock|null
     */
    public function update(int $id, array $data): ?ItemInStock
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id);
        if (!$itemInStock) {
            return null;
        }
        unset($data['illustration_picture_path']);
        return $this->itemInStockRepository->updateItemInStock($itemInStock, $data);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @return ItemInStock|null
     */
    public function updateIllustrationPicture(int $id, UploadedFile $uploadedFile): ?ItemInStock
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id);
        if (!$itemInStock) {
            return null;
        }
        $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'item_in_stock_illustration_pictures');
        $data['illustration_picture_path'] = $filePath;

        if ($itemInStock->illustration_picture_path) {
            Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path));
        }
        return $this->itemInStockRepository->updateItemInStock($itemInStock, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteIllustrationPicture(int $id): bool
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id);
        if (!$itemInStock || !$itemInStock->illustration_picture_path) {
            return false;
        }
        Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path));
        $data['illustration_picture_path'] = null;
        $this->itemInStockRepository->updateItemInStock($itemInStock, $data);
        return true;

    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return bool
     */
    public function softDelete(int $id, bool $includeTrashed = false, array $columns = ['*']): bool
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id, $includeTrashed, $columns);
        if (!$itemInStock) {
            return false;
        }
        return $this->itemInStockRepository->softDeleteItemInStock($itemInStock);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id, true);
        if (!$itemInStock) {
            return false;
        }
         if ($itemInStock->illustration_picture_path) {
            Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path));
        }
        return $this->itemInStockRepository->forceDeleteItemInStock($itemInStock);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $itemInStock = $this->itemInStockRepository->findItemInStockById($id, true);
        if (!$itemInStock) {
            return false;
        }
        if ($itemInStock->illustration_picture_path) {
            Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path));
        }
        return $this->itemInStockRepository->restoreItemInStock($itemInStock);
    }
}
