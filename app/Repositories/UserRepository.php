<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\FilteredIndexer;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use LogicException;

class UserRepository implements FilteredIndexer
{

    /**
     * @param mixed $query
     * @param array<string, mixed> $filters ['column' => ['operator', 'value']]
     * @return mixed
     */
    private function applyFilters(&$query, array $filters)
    {
        if(!empty($filters)) {
            foreach($filters as $column => $searchValues) {
                $query->where($column, $searchValues['operator'], $searchValues['value']);
            }
        }
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = User::query();
        $this->applyFilters($query, $filters);
        return $query->paginate($perPage);
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array<string> $columns
     * @return User|null
     */
    public function findUserById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?User
    {
        return User::withTrashed($includeTrashed)->find($id, $columns);
    }

    /**
     * @param array<string, mixed> $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDeleteUser(User $user): bool
    {
        return (bool) $user->delete();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDeleteUser(User $user): bool
    {
        return (bool) $user->forceDelete();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restoreUser(User $user): bool
    {
        if($user->deleted_at === null) {
            throw new LogicException('Cannot restore a user that is not soft-deleted.');
        }
        return (bool) $user->restore();
    }
}
