<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Traits\UploadFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use UploadFiles;

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
        try {
            if (isset($data['profile_picture_path']) && $data['profile_picture_path'] instanceof UploadedFile) {
                $uploadedFile = $data['profile_picture_path'];
                $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'user_profile_pictures');
                $data['profile_picture_path'] = $filePath;
            }
            return $this->userRepository->createUser($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        try {
            $user = $this->userRepository->findUserById($id);
            if (!$user) {
                return null;
            }
            unset($data['profile_picture_path']);
            return $this->userRepository->updateUser($user, $data);

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @return User|null
     */
    public function updateProfilePicture(int $id, UploadedFile $uploadedFile): ?User
    {
        try {
            $user = $this->userRepository->findUserById($id);
            if (!$user) {
                return null;
            }
            $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'user_profile_pictures');
            $data['profile_picture_path'] = $filePath;

            if ($user->profile_picture_path) {
                Storage::disk('public')->delete('user_profile_pictures/' . basename($user->profile_picture_path));
            }
            return $this->userRepository->updateUser($user, $data);

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteProfilePicture(int $id): bool
    {
        try {
            $user = $this->userRepository->findUserById($id);
            if (!$user || !$user->profile_picture_path) {
                return false;
            }
            Storage::disk('public')->delete('user_profile_pictures/' . basename($user->profile_picture_path));
            $data['profile_picture_path'] = null;
            $this->userRepository->updateUser($user, $data);
            return true;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {
        $user = $this->userRepository->findUserById($id);
        if (!$user) {
            return false;
        }
        return $this->userRepository->softDeleteUser($user);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $user = $this->userRepository->findUserById($id, true);
        if (!$user) {
            return false;
        }
        if ($user->profile_picture_path) {
            Storage::disk('public')->delete('user_profile_pictures/' . basename($user->profile_picture_path));
        }
        return $this->userRepository->forceDeleteUser($user);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $user = $this->userRepository->findUserById($id, true);
        if (!$user) {
            return false;
        }
        return $this->userRepository->restoreUser($user);
    }
}
