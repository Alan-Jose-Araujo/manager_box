<?php

namespace Tests\Unit\Services;

use App\Models\ItemInStockCategory;
use App\Services\ItemInStockCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemInStockCategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private ItemInStockCategoryService $itemInStockCategoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemInStockCategoryService = new ItemInStockCategoryService();
    }

    // Find Item in stock by id tests.

    public function testItCanFindAnItemInStockCategoryById(): void
    {
        $createdItemInStockCategory = ItemInStockCategory::factory()->create();
        $foundItemInStockCategory = $this->itemInStockCategoryService->find($createdItemInStockCategory->id);
        $this->assertNotNull($foundItemInStockCategory);
        $this->assertInstanceOf(ItemInStockCategory::class, $foundItemInStockCategory);
        $this->assertEquals($createdItemInStockCategory->id, $foundItemInStockCategory->id);
    }

    public function testItReturnsNullWhenItemInStockCategoryNotFound(): void
    {
        $foundItemInStockCategory = $this->itemInStockCategoryService->find(999);
        $this->assertNull($foundItemInStockCategory);
    }

    // Create Item in stock tests.

    public function testItCanCreateAnItemInStockCategory(): void
    {
        $data = ItemInStockCategory::factory()->make()->toArray();
        $createdItemInStockCategory = $this->itemInStockCategoryService->create($data);
        $this->assertInstanceOf(ItemInStockCategory::class, $createdItemInStockCategory);
        $this->assertDatabaseHas('item_in_stock_categories', $data);
    }

    // Update Item in stock tests.

    public function testItCanUpdateAnItemInStockCategory(): void
    {
        $itemInStock = ItemInStockCategory::factory()->create();
        $data = ['name' => 'Updated name'];
        $updatedItemInStockCategory = $this->itemInStockCategoryService->update($itemInStock->id, $data);
        $this->assertNotNull($updatedItemInStockCategory);
        $this->assertEquals($data['name'], $updatedItemInStockCategory->name);
        $this->assertDatabaseHas('item_in_stock_categories', ['id' => $itemInStock->id]);
    }

    // Delete Item in stock tests.

    public function testItCanSoftDeleteAnItemInStockCategory(): void
    {
        $itemInStock = ItemInStockCategory::factory()->create();
        $result = $this->itemInStockCategoryService->softDelete($itemInStock->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('item_in_stock_categories', ['id' => $itemInStock->id]);
    }

    public function testItCanForceDeleteAnItemInStockCategory(): void
    {
        $itemInStock = ItemInStockCategory::factory()->create();
        $result = $this->itemInStockCategoryService->forceDelete($itemInStock->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('item_in_stock_categories', ['id' => $itemInStock->id]);
    }

    public function testItCanRestoreASoftDeletedItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $this->itemInStockCategoryService->softDelete($itemInStockCategory->id);
        $result = $this->itemInStockCategoryService->restore($itemInStockCategory->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('item_in_stock_categories', ['id' => $itemInStockCategory->id, 'deleted_at' => null]);
    }
}
