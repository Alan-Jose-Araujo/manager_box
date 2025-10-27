<?php

namespace Tests\Unit\Services;

use App\Models\ItemInStock;
use App\Services\ItemInStockService;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemInStockServiceTest extends TestCase
{
    use RefreshDatabase;
    use UploadFiles;

    private ItemInStockService $itemInStockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->itemInStockService = new ItemInStockService();
    }

    // Find Item in stock by id tests.

    public function testItCanFindAnItemInStockById(): void
    {
        $createdItemInStock = ItemInStock::factory()->create();
        $foundItemInStock = $this->itemInStockService->find($createdItemInStock->id);
        $this->assertNotNull($foundItemInStock);
        $this->assertInstanceOf(ItemInStock::class, $foundItemInStock);
        $this->assertEquals($createdItemInStock->id, $foundItemInStock->id);
    }

    public function testItReturnsNullWhenItemInStockNotFound(): void
    {
        $foundItemInStock = $this->itemInStockService->find(999);
        $this->assertNull($foundItemInStock);
    }

    // Create Item in stock tests.

    public function testItCanCreateAnItemInStockWithoutIllustrationPicture(): void
    {
        $data = ItemInStock::factory()->make()->toArray();
        $createdItemInStock = $this->itemInStockService->create($data);
        $this->assertInstanceOf(ItemInStock::class, $createdItemInStock);
        $this->assertDatabaseHas('items_in_stock', $data);
    }

     public function testItCanCreatenAnItemInStockWithIllustrationPicture(): void
    {
        $data = ItemInStock::factory()->make()->toArray();
        $data['illustration_picture_path'] = $this->generateFakeFile([
            'name' => 'illustration_picture.jpg',
            'mimeType' => 'image/jpg',
        ]);
        $createdItemInStock = $this->itemInStockService->create($data);
        $data['illustration_picture_path'] = $createdItemInStock->illustration_picture_path;
        $this->assertInstanceOf(ItemInStock::class, $createdItemInStock);
        $this->assertDatabaseHas('items_in_stock', $data);
        $this->assertFileExists(
            storage_path('app/public/item_in_stock_illustration_pictures/' . basename($createdItemInStock->illustration_picture_path))
        );
        Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($createdItemInStock->illustration_picture_path));
    }

    // Update Item in stock tests.

    public function testItCanUpdateAnItemInStock(): void
    {
        $itemInStock = ItemInStock::factory()->create();
        $data = ['name' => 'Updated name'];
        $updatedItemInStock = $this->itemInStockService->update($itemInStock->id, $data);
        $this->assertNotNull($updatedItemInStock);
        $this->assertEquals($data['name'], $updatedItemInStock->name);
        $this->assertDatabaseHas('items_in_stock', ['id' => $itemInStock->id]);
    }

    public function testItCanUpdateAnItemInStockIllustrationPicture(): void
    {
        $itemInStock = ItemInStock::factory()->create();
        $newIllustrationPicture = $this->generateFakeFile([
            'name' => 'new_illustration_picture',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedItemInStock = $this->itemInStockService->updateIllustrationPicture($itemInStock->id, $newIllustrationPicture);
        $this->assertNotNull($updatedItemInStock);
        $this->assertNotNull($updatedItemInStock->illustration_picture_path);
        $this->assertDatabaseHas('items_in_stock', ['id' => $itemInStock->id]);
        $this->assertFileExists(
            storage_path('app/public/item_in_stock_illustration_pictures/' . basename($updatedItemInStock->illustration_picture_path))
        );
        Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($updatedItemInStock->illustration_picture_path));
    }

    public function testItCanUpdateItemInStockIllustrationPictureReplacingOldOne(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_illustration_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $itemInStock = ItemInStock::factory()->create([
            'illustration_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'item_in_stock_illustration_pictures')
        ]);
        $newIllustrationPicture = $this->generateFakeFile([
            'name' => 'new_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedItemInStock = $this->itemInStockService->updateIllustrationPicture($itemInStock->id, $newIllustrationPicture);
        $this->assertNotNull($updatedItemInStock);
        $this->assertNotNull($updatedItemInStock->illustration_picture_path);
        $this->assertDatabaseHas('items_in_stock', ['id' => $itemInStock->id]);
        $this->assertFileExists(
            storage_path('app/public/item_in_stock_illustration_pictures/' . basename($updatedItemInStock->illustration_picture_path))
        );
        Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($updatedItemInStock->illustration_picture_path));
        Storage::disk('public')->delete('item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path));
    }

    public function testItCanDeleteAnItemInStockIllustrationPicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_Illustration_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $itemInStock = ItemInStock::factory()->create([
            'Illustration_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'item_in_stock_illustration_pictures')
        ]);
        $result = $this->itemInStockService->deleteIllustrationPicture($itemInStock->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('items_in_stock', ['id' => $itemInStock->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/item_in_stock_illustration_pictures/' . basename($itemInStock->Illustration_picture_path))
        );
    }

    // Delete Item in stock tests.

    public function testItCanSoftDeleteAnItemInStock(): void
    {
        $itemInStock = ItemInStock::factory()->create();
        $result = $this->itemInStockService->softDelete($itemInStock->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('items_in_stock', ['id' => $itemInStock->id]);
    }

    public function testItCanForceDeleteAnItemInStockWithoutIllustrationPicture(): void
    {
        $itemInStock = ItemInStock::factory()->create();
        $result = $this->itemInStockService->forceDelete($itemInStock->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('items_in_stock', ['id' => $itemInStock->id]);
    }

    public function testItCanForceDeleteAnItemInStockWithIllustrationPicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_illustration_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $itemInStock = ItemInStock::factory()->create([
            'illustration_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'item_in_stock_illustration_pictures')
        ]);
        $result = $this->itemInStockService->forceDelete($itemInStock->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('items_in_stock', ['id' => $itemInStock->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/item_in_stock_illustration_pictures/' . basename($itemInStock->illustration_picture_path))
        );
    }
}
