<?php

namespace Tests\Unit\Services;

use App\Models\Warehouse;
use App\Services\WarehouseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarehouseServiceTest extends TestCase
{
    use RefreshDatabase;

    private WarehouseService $warehouseService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->warehouseService = new WarehouseService();
    }

    // Find address by id tests.

    public function testItCanFindAnWarehouseById(): void
    {
        $createdWarehouse = Warehouse::factory()->create();
        $foundWarehouse = $this->warehouseService->find($createdWarehouse->id);
        $this->assertNotNull($foundWarehouse);
        $this->assertInstanceOf(Warehouse::class, $foundWarehouse);
        $this->assertEquals($createdWarehouse->id, $foundWarehouse->id);
    }

    public function testItReturnsNullWhenWarehouseNotFound(): void
    {
        $foundWarehouse = $this->warehouseService->find(999);
        $this->assertNull($foundWarehouse);
    }

    // Create address tests

    public function testItCanCreateAnWarehouse(): void
    {
        $data = Warehouse::factory()->make()->toArray();
        $createdWarehouse = $this->warehouseService->create($data);
        $this->assertInstanceOf(Warehouse::class, $createdWarehouse);
        $this->assertDatabaseHas('warehouses', $data);
    }

    // Update address tests

    public function testItCanUpdateAnWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $data = ['name' => 'New name'];
        $updatedWarehouse = $this->warehouseService->update($warehouse->id, $data);
        $this->assertInstanceOf(Warehouse::class, $updatedWarehouse);
        $this->assertEquals($data['name'], $updatedWarehouse->name);
        $this->assertDatabaseHas('warehouses', ['id' => $warehouse->id]);
    }

    // Delete address tests

    public function testItCanSoftDeleteAnWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $result = $this->warehouseService->softDelete($warehouse->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('warehouses', ['id' => $warehouse->id]);
    }

    public function testItCanForceDeleteAnWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $result = $this->warehouseService->forceDelete($warehouse->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }

    public function testItCanForceDeleteASoftDeletedWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $this->warehouseService->softDelete($warehouse->id);
        $result = $this->warehouseService->forceDelete($warehouse->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }

    public function testItCanRestoreASoftDeletedWarehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        $this->warehouseService->softDelete($warehouse->id);
        $result = $this->warehouseService->restore($warehouse->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('warehouses', ['id' => $warehouse->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedAdress(): void
    {
        $this->expectException(\LogicException::class);
        $warehouse = Warehouse::factory()->create();
        $this->warehouseService->restore($warehouse->id);
    }
}
