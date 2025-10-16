<?php

namespace Tests\Unit\Repositories;

use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarehouseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private WarehouseRepository $warehouseRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->warehouseRepository = new WarehouseRepository();
    }

    // Find warehouse by id tests.

    public function testItCanFindAWarehouseById(): void
    {
        $createdWarehouse = Warehouse::factory()->create();
        $foundWarehouse = $this->warehouseRepository->findWarehouseById($createdWarehouse->id);
        $this->assertNotNull($foundWarehouse);
        $this->assertInstanceOf(Warehouse::class, $foundWarehouse);
        $this->assertEquals($createdWarehouse->id, $foundWarehouse->id);
    }

    public function testItReturnsNullWhenWarehouseNotFound(): void
    {
        $foundWarehouse = $this->warehouseRepository->findWarehouseById(999);
        $this->assertNull($foundWarehouse);
    }

    // Create warehouse tests.

    public function testItCanCreateAWarehouse(): void
    {
        $data = Warehouse::factory()->make()->toArray();
        $createdWarehouse = $this->warehouseRepository->createWarehouse($data);
        $this->assertInstanceOf(Warehouse::class, $createdWarehouse);
        $this->assertDatabaseHas('warehouses', $data);
    }

    // Update warehouse tests.

     public function testItCanUpdateAWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create([
            'name' => 'Old name',
        ]);
        $data = ['name' => 'New Name'];
        $updatedWarehouse = $this->warehouseRepository->updateWarehouse($warehouse, $data);
        $this->assertInstanceOf(Warehouse::class, $updatedWarehouse);
        $this->assertEquals($data['name'], $updatedWarehouse->name);
        $this->assertDatabaseHas('warehouses', ['id' => $warehouse->id]);
    }

    // Delete warehouse tests.

    public function testItCanSoftDeleteAWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $result = $this->warehouseRepository->softDeleteWarehouse($warehouse);
        $this->assertTrue($result);
        $this->assertSoftDeleted('warehouses', ['id' => $warehouse->id]);
    }

    public function testItCanForceDeleteASoftDeletedWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $this->warehouseRepository->softDeleteWarehouse($warehouse);
        $result = $this->warehouseRepository->forceDeleteWarehouse($warehouse);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }

    // Restore warehouse tests.

    public function testItCanRestoreASoftDeletedWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $this->warehouseRepository->softDeleteWarehouse($warehouse);
        $result = $this->warehouseRepository->restoreWarehouse($warehouse);
        $this->assertTrue($result);
        $this->assertDatabaseHas('warehouses', ['id' => $warehouse->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedWarehouse(): void
    {
        $this->expectException(\LogicException::class);
        $warehouse = Warehouse::factory()->create();
        $this->warehouseRepository->restoreWarehouse($warehouse);
    }
}
