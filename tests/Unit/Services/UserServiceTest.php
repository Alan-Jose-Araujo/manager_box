<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    use UploadFiles;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    // Find User by ID tests.

    public function testItCanFindAUserById(): void
    {
        $createdUser = User::factory()->create();
        $foundUser = $this->userService->find($createdUser->id);
        $this->assertNotNull($foundUser);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($createdUser->id, $foundUser->id);
    }

    public function testItReturnsNullWhenUserNotFound(): void
    {
        $foundUser = $this->userService->find(999);
        $this->assertNull($foundUser);
    }

    // Create User tests.

    public function testItCanCreateAUserWithoutProfilePicture(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $createdUser = $this->userService->create($data);
        $this->assertInstanceOf(User::class, $createdUser);
        unset($data['password']);
        unset($data['email_verified_at']);
        $this->assertDatabaseHas('users', $data);
    }

    public function testItCanCreateAUserWithProfilePicture(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $data['profile_picture_path'] = $this->generateFakeFile([
            'name' => 'profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $createdUser = $this->userService->create($data);
        $data['profile_picture_path'] = $createdUser->profile_picture_path;
        $this->assertInstanceOf(User::class, $createdUser);
        unset($data['password']);
        unset($data['email_verified_at']);
        $this->assertDatabaseHas('users', $data);
        $this->assertFileExists(
            storage_path('app/public/user_profile_pictures/' . basename($createdUser->profile_picture_path))
        );
        Storage::disk('public')->delete('user_profile_pictures/' . basename($createdUser->profile_picture_path));
    }

    // Update User tests.

    public function testItCanUpdateAUser(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
        ]);
        $data = ['name' => 'New Name'];
        $updatedUser = $this->userService->update($user->id, $data);
        $this->assertNotNull($updatedUser);
        $this->assertEquals($data['name'], $updatedUser->name);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function testItCanUpdateAUserProfilePicture(): void
    {
        $user = User::factory()->create();
        $newProfilePicture = $this->generateFakeFile([
            'name' => 'new_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedUser = $this->userService->updateProfilePicture($user->id, $newProfilePicture);
        $this->assertNotNull($updatedUser);
        $this->assertNotNull($updatedUser->profile_picture_path);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertFileExists(
            storage_path('app/public/user_profile_pictures/' . basename($updatedUser->profile_picture_path))
        );
        Storage::disk('public')->delete('user_profile_pictures/' . basename($updatedUser->profile_picture_path));
    }

    public function testItCanUpdateUserProfilePictureReplacingOldOne(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $user = User::factory()->create([
            'profile_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'user_profile_pictures')
        ]);
        $newProfilePicture = $this->generateFakeFile([
            'name' => 'new_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedUser = $this->userService->updateProfilePicture($user->id, $newProfilePicture);
        $this->assertNotNull($updatedUser);
        $this->assertNotNull($updatedUser->profile_picture_path);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertFileExists(
            storage_path('app/public/user_profile_pictures/' . basename($updatedUser->profile_picture_path))
        );
        Storage::disk('public')->delete('user_profile_pictures/' . basename($updatedUser->profile_picture_path));
        Storage::disk('public')->delete('user_profile_pictures/' . basename($user->profile_picture_path));
    }

    public function testItCanDeleteAUserProfilePicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $user = User::factory()->create([
            'profile_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'user_profile_pictures')
        ]);
        $result = $this->userService->deleteProfilePicture($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/user_profile_pictures/' . basename($user->profile_picture_path))
        );
    }

    // Delete User tests.

    public function testItCanSoftDeleteAUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userService->softDelete($user->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testItCanForceDeleteAUserWithoutProfilePicture(): void
    {
        $user = User::factory()->create();
        $result = $this->userService->forceDelete($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testItCanForceDeleteAUserWithProfilePicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $user = User::factory()->create([
            'profile_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'user_profile_pictures')
        ]);
        $result = $this->userService->forceDelete($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/user_profile_pictures/' . basename($user->profile_picture_path))
        );
    }

    public function testItCanRestoreASoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $this->userService->softDelete($user->id);
        $result = $this->userService->restore($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }
}
