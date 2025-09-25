<?php

namespace Tests\Unit\Services;

use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    use RefreshDatabase;

    private AddressService $addressService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->addressService = new AddressService();
    }

    // Find User by ID tests.

    public function testItCanFindAnAddressById(): void
    {
        $createdAddress = Address::factory()->create();
        $foundAddress = $this->addressService->find($createdAddress->id);
        $this->assertNotNull($foundAddress);
        $this->assertInstanceOf(Address::class, $foundAddress);
        $this->assertEquals($createdAddress->id, $createdAddress->id);
    }

    public function testItReturnsNullWhenAddressNotFound(): void
    {
        $foundAddress = $this->addressService->find(999);
        $this->assertNull($foundAddress);
    }

    // Create User tests.

    public function testItCanCreateAnAddress(): void
    {
        $data = Address::factory()->make()->toArray();
        $createdAddress = $this->addressService->create($data);
        $this->assertInstanceOf(Address::class, $createdAddress);
        $this->assertDatabaseHas('addresses', $data);
    }

    // Update User tests.

    public function testItCanUpdateAnAddress(): void
    {
        $address = Address::factory()->create();
        $data = ['street' => 'New street name'];
        $updatedAddress = $this->addressService->update($address->id, $data);
        $this->assertNotNull($updatedAddress);
        $this->assertEquals($data['street'], $updatedAddress->street);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    // Delete User tests.

    public function testItCanSoftDeleteAnAddress(): void
    {
        $address = Address::factory()->create();
        $result = $this->addressService->softDelete($address->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('addresses', ['id' => $address->id]);
    }

    public function testItCanForceDeleteAnAddress(): void
    {
        $address = Address::factory()->create();
        $result = $this->addressService->forceDelete($address->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function testItCanRestoreASoftDeletedAddress(): void
    {
        $address = Address::factory()->create();
        $this->addressService->softDelete($address->id);
        $result = $this->addressService->restore($address->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('addresses', ['id' => $address->id, 'deleted_at' => null]);
    }
}
