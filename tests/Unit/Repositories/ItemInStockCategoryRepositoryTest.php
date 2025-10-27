<?php

namespace Tests\Unit\Repositories;

use App\Models\ItemInStockCategory;
use App\Repositories\ItemInStockCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemInStockCategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ItemInStockCategoryRepository $itemInStockCategoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemInStockCategoryRepository = new ItemInStockCategoryRepository();
    }

     // Find ItemInStockCategory by ID tests.

    public function testItCanFindAItemInStockCategoryById(): void
    {
        $createdItemInStockCategory = ItemInStockCategory::factory()->create();
        $foundItemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById($createdItemInStockCategory->id);
        $this->assertNotNull($foundItemInStockCategory);
        $this->assertInstanceOf(ItemInStockCategory::class, $foundItemInStockCategory);
        $this->assertEquals($createdItemInStockCategory->id, $foundItemInStockCategory->id);
    }

    public function testItReturnsNullWhenItemInStockCategoryNotFound(): void
    {
        $foundItemInStockCategory = $this->itemInStockCategoryRepository->findItemInStockCategoryById(999);
        $this->assertNull($foundItemInStockCategory);
    }

    // Create ItemInStockCategory tests.

    public function testItCanCreateAItemInStockCategory(): void
    {
        $data = ItemInStockCategory::factory()->make()->toArray();
        $createdItemInStockCategory = $this->itemInStockCategoryRepository->createItemInStockCategory($data);
        $this->assertInstanceOf(ItemInStockCategory::class, $createdItemInStockCategory);
        $this->assertDatabaseHas('item_in_stock_categories', $data);
    }

    // Update ItemInStockCategory tests.

    public function testItCanUpdateAItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create([
            'name' => 'Old Name',
        ]);
        $data = ['name' => 'New Name'];
        $updatedItemInStockCategory = $this->itemInStockCategoryRepository->updateItemInStockCategory($itemInStockCategory, $data);
        $this->assertInstanceOf(ItemInStockCategory::class, $updatedItemInStockCategory);
        $this->assertEquals($data['name'], $updatedItemInStockCategory->name);
        $this->assertDatabaseHas('item_in_stock_categories', ['id' => $itemInStockCategory->id]);
    }

    // Delete ItemInStockCategory tests.

    public function testItCanSoftDeleteAItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $result = $this->itemInStockCategoryRepository->softDeleteItemInStockCategory($itemInStockCategory);
        $this->assertTrue($result);
        $this->assertSoftDeleted('item_in_stock_categories', ['id' => $itemInStockCategory->id]);
    }

    public function testItCanForceDeleteAItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $result = $this->itemInStockCategoryRepository->forceDeleteItemInStockCategory($itemInStockCategory);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('item_in_stock_categories', ['id' => $itemInStockCategory->id]);
    }

    public function testItCanForceDeleteASoftDeletedItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $this->itemInStockCategoryRepository->softDeleteItemInStockCategory($itemInStockCategory);
        $result = $this->itemInStockCategoryRepository->forceDeleteItemInStockCategory($itemInStockCategory);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('item_in_stock_categories', ['id' => $itemInStockCategory->id]);
    }

    // Restore ItemInStockCategory tests.

    public function testItCanRestoreASoftDeletedItemInStockCategory(): void
    {
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $this->itemInStockCategoryRepository->softDeleteItemInStockCategory($itemInStockCategory);
        $result = $this->itemInStockCategoryRepository->restoreItemInStockCategory($itemInStockCategory);
        $this->assertTrue($result);
        $this->assertDatabaseHas('item_in_stock_categories', ['id' => $itemInStockCategory->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedItemInStockCategory(): void
    {
        $this->expectException(\LogicException::class);
        $itemInStockCategory = ItemInStockCategory::factory()->create();
        $this->itemInStockCategoryRepository->restoreItemInStockCategory($itemInStockCategory);
    }
}
