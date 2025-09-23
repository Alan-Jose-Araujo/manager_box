<?php

namespace Tests\Unit\Repositories;

use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AddressRepository $addressRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->addressRepository = new AddressRepository();
    }

    // Find address by id tests.

    public function testItCanFindAnAddressById(): void
    {
        $createdAddress = Address::factory()->create();
        $foundAddress = $this->addressRepository->findAddressById($createdAddress->id);
        $this->assertNotNull($foundAddress);
        $this->assertInstanceOf(Address::class, $foundAddress);
        $this->assertEquals($createdAddress->id, $foundAddress->id);
    }

    public function testItReturnsNullWhenAddressNotFound(): void
    {
        $foundAddress = $this->addressRepository->findAddressById(999);
        $this->assertNull($foundAddress);
    }

    // Create address tests

    public function testItCanCreateAnAddress(): void
    {
        $data = Address::factory()->make()->toArray();
        $createdAddress = $this->addressRepository->createAddress($data);
        $this->assertInstanceOf(Address::class, $createdAddress);
        $this->assertDatabaseHas('addresses', $data);
    }

    // Update address tests

    public function testItCanUpdateAnAddress(): void
    {
        $address = Address::factory()->create();
        $data = ['street' => 'New street'];
        $updatedAddress = $this->addressRepository->updateCompany($address, $data);
        $this->assertInstanceOf(Address::class, $updatedAddress);
        $this->assertEquals($data['street'], $updatedAddress->street);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    // Delete address tests

    public function testItCanSoftDeleteAnAddress(): void
    {
        $address = Address::factory()->create();
        $result = $this->addressRepository->softDeleteAddress($address);
        $this->assertTrue($result);
        $this->assertSoftDeleted('addresses', ['id' => $address->id]);
    }

    public function testItCanForceDeleteAnAddress(): void
    {
        $address = Address::factory()->create();
        $result = $this->addressRepository->forceDeleteAddress($address);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function testItCanForceDeleteASoftDeletedAddress(): void
    {
        $address = Address::factory()->create();
        $this->addressRepository->softDeleteAddress($address);
        $result = $this->addressRepository->forceDeleteAddress($address);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function testItCanRestoreASoftDeletedAddress(): void
    {
        $address = Address::factory()->create();
        $this->addressRepository->softDeleteAddress($address);
        $result = $this->addressRepository->restoreAddress($address);
        $this->assertTrue($result);
        $this->assertDatabaseHas('addresses', ['id' => $address->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedAdress(): void
    {
        $this->expectException(\LogicException::class);
        $address = Address::factory()->create();
        $this->addressRepository->restoreAddress($address);
    }
}
