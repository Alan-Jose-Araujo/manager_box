<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return User|null
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?User
    {
        return $this->userRepository->findUserById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userRepository->createUser($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        return $this->userRepository->updateUser($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {
        return $this->userRepository->softDeleteUser($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        return $this->userRepository->forceDeleteUser($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->userRepository->restoreUser($id);
    }
}
