<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
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

    // Paginate Users.

    public function testItCanPaginateUsersWithoutFilters(): void
    {
        // Creating users to paginate.
        $userCount = 10;
        User::factory()->count($userCount)->create();

        $paginatedResults = $this->userRepository->paginate();

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginatedResults);
        $this->assertEquals($userCount, $paginatedResults->total());
    }

    public function testItCanPaginateUsersWithFilters(): void
    {
        // Creating users to paginate.
        $userCount = 10;
        User::factory()->count($userCount)->create([
            'name' => 'Test User Count: ',
        ])->each(function(User $user, int $index) {
            $user->name = $user->name . $index;
        });

        $filters = [
            'id' => [
                'operator' => '>',
                'value' => 5,
            ],
        ];

        $paginatedResults = $this->userRepository->paginate($filters);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginatedResults);
        $this->assertEquals(5, $paginatedResults->total());
    }

    // Find User by ID tests.

    public function testItCanFindAUserById(): void
    {
        $createdUser = User::factory()->create();
        $foundUser = $this->userRepository->findUserById($createdUser->id);
        $this->assertNotNull($foundUser);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($createdUser->id, $foundUser->id);
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
        $updatedUser = $this->userRepository->updateUser($user, $data);
        $this->assertInstanceOf(User::class, $updatedUser);
        $this->assertEquals($data['name'], $updatedUser->name);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    // Delete User tests.

    public function testItCanSoftDeleteAUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userRepository->softDeleteUser($user);
        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testItCanForceDeleteAUser(): void
    {
        $user = User::factory()->create();
        $result = $this->userRepository->forceDeleteUser($user);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testItCanForceDeleteASoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $this->userRepository->softDeleteUser($user);
        $result = $this->userRepository->forceDeleteUser($user);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Restore User tests.

    public function testItCanRestoreASoftDeletedUser(): void
    {
        $user = User::factory()->create();
        $this->userRepository->softDeleteUser($user);
        $result = $this->userRepository->restoreUser($user);
        $this->assertTrue($result);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedUser(): void
    {
        $this->expectException(\LogicException::class);
        $user = User::factory()->create();
        $this->userRepository->restoreUser($user);
    }
}
