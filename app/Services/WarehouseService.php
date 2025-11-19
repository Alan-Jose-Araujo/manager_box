<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class WarehouseService
{
    private WarehouseRepository $warehouseRepository;

    public function __construct()
    {
        $this->warehouseRepository = new WarehouseRepository();
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->warehouseRepository->paginate($filters, $perPage);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Warehouse|\Illuminate\Database\Eloquent\Builder<Warehouse>
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Warehouse
    {
        return $this->warehouseRepository->findWarehouseById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return Warehouse
     */
    public function create(array $data): Warehouse
    {
        return $this->warehouseRepository->createWarehouse($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Warehouse|null
     */
    public function update(int $id, array $data): ?Warehouse
    {
        $warehose = $this->warehouseRepository->findWarehouseById($id);
        if (!$warehose) {
            return null;
        }
        return $this->warehouseRepository->updateWarehouse($warehose, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {
        $warehose = $this->warehouseRepository->findWarehouseById($id);
        if (!$warehose) {
            return false;
        }
        return $this->warehouseRepository->softDeleteWarehouse($warehose);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $warehose = $this->warehouseRepository->findWarehouseById($id, true);
        if (!$warehose) {
            return false;
        }
        return $this->warehouseRepository->forceDeleteWarehouse($warehose);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $warehose = $this->warehouseRepository->findWarehouseById($id, true);
        if (!$warehose) {
            return false;
        }
        return $this->warehouseRepository->restoreWarehouse($warehose);
    }
}
