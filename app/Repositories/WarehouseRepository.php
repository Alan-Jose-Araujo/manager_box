<?php

namespace App\Repositories;

use App\Models\Warehouse;
use LogicException;

class WarehouseRepository
{
    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Warehouse|\Illuminate\Database\Eloquent\Builder<Warehouse>
     */
    public function findWarehouseById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Warehouse
    {
        return Warehouse::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array $data
     * @return Warehouse
     */
    public function createWarehouse(array $data): Warehouse
    {
        return Warehouse::create($data);
    }

    /**
     * @param \App\Models\Warehouse $warehouse
     * @param array $data
     * @return Warehouse
     */
    public function updateWarehouse(Warehouse $warehouse, array $data): Warehouse
    {
        $warehouse->update($data);
        return $warehouse;
    }

    /**
     * @param \App\Models\Warehouse $warehouse
     * @return bool
     */
    public function softDeleteWarehouse(Warehouse $warehouse): bool
    {
        return (bool) $warehouse->delete();
    }

    /**
     * @param \App\Models\Warehouse $warehouse
     * @return bool
     */
    public function forceDeleteWarehouse(Warehouse $warehouse): bool
    {
        return (bool) $warehouse->forceDelete();
    }

    /**
     * @param \App\Models\Warehouse $warehouse
     * @throws \LogicException
     * @return bool
     */
    public function restoreWarehouse(Warehouse $warehouse): bool
    {
        if($warehouse->deleted_at === null) {
            throw new LogicException('Cannot restore a user that is not soft-deleted.');
        }
        return (bool) $warehouse->restore();
    }
}
