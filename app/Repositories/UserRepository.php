<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
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
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->findUserById($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDeleteUser(int $id): bool
    {
        $user = $this->findUserById($id);
        return $user ? (bool) $user->delete() : false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDeleteUser(int $id): bool
    {
        $user = $this->findUserById($id, true);
        return $user ? (bool) $user->forceDelete() : false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restoreUser(int $id): bool
    {
        $user = $this->findUserById($id, true);
        return $user && !is_null($user->deleted_at) ? (bool) $user->restore() : false;
    }
}
