<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    // Find User by ID tests.

    public function testItCanFindAUserById(): void
    {
        User::factory()->create();
        $foundUser = $this->userRepository->findUserById(1);
        $this->assertNotNull($foundUser);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals(1, $foundUser->id);
    }

    public function testItReturnsNullWhenUserNotFound(): void
    {
        $foundUser = $this->userRepository->findUserById(999);
        $this->assertNull($foundUser);
    }

    // Create User tests.

    public function testItCanCreateAUser(): void
    {
        $data = User::factory()->make()->makeVisible([
            'password',
        ])->toArray();
        $createdUser = $this->userRepository->createUser($data);
        $this->assertInstanceOf(User::class, $createdUser);
        unset($data['password']);
        unset($data['email_verified_at']);
        $this->assertDatabaseHas('users', $data);
    }

    // Update User tests.

    public function testItCanUpdateAUser(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
        ]);
        $data = ['name' => 'New Name'];
        $updatedUser = $this->userRepository->updateUser($user->id, $data);
        $this->assertNotNull($updatedUser);
        $this->assertEquals($data['name'], $updatedUser->name);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function testItReturnsNullWhenUpdatingNonExistentUser(): void
    {
        $data = ['name' => 'New Name'];
        $updatedUser = $this->userRepository->updateUser(999, $data);
        $this->assertNull($updatedUser);
    }

    // Delete User tests.

    public function testItCanSoftDeleteAUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userRepository->softDeleteUser($user->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testItReturnsFalseWhenSoftDeletingNonExistentUser(): void
    {
        $result = $this->userRepository->softDeleteUser(999);
        $this->assertFalse($result);
    }

    public function testItCanForceDeleteAUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userRepository->forceDeleteUser($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testItReturnsFalseWhenForceDeletingNonExistentUser(): void
    {
        $result = $this->userRepository->forceDeleteUser(999);
        $this->assertFalse($result);
    }

    public function testItCanForceDeleteASoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $this->userRepository->softDeleteUser($user->id);
        $result = $this->userRepository->forceDeleteUser($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Restore User tests.

    public function testItCanRestoreASoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $this->userRepository->softDeleteUser($user->id);
        $result = $this->userRepository->restoreUser($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function testItReturnsFalseWhenRestoringNonExistentUser(): void
    {
        $result = $this->userRepository->restoreUser(999);
        $this->assertFalse($result);
    }

    public function testItReturnsFalseWhenRestoringNonSoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userRepository->restoreUser($user->id);
        $this->assertFalse($result);
    }
}
