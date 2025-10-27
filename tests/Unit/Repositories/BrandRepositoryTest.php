<?php

namespace Tests\Unit\Repositories;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private BrandRepository $brandRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->brandRepository = new BrandRepository();
    }

    // Find address by id tests.

    public function testItCanFindAnBrandById(): void
    {
        $createdBrand = Brand::factory()->create();
        $foundBrand = $this->brandRepository->findBrandById($createdBrand->id);
        $this->assertNotNull($foundBrand);
        $this->assertInstanceOf(Brand::class, $foundBrand);
        $this->assertEquals($createdBrand->id, $foundBrand->id);
    }

    public function testItReturnsNullWhenBrandNotFound(): void
    {
        $foundBrand = $this->brandRepository->findBrandById(999);
        $this->assertNull($foundBrand);
    }

    // Create address tests

    public function testItCanCreateAnBrand(): void
    {
        $data = Brand::factory()->make()->toArray();
        $createdBrand = $this->brandRepository->createBrand($data);
        $this->assertInstanceOf(Brand::class, $createdBrand);
        $this->assertDatabaseHas('brands', $data);
    }

    // Update address tests

    public function testItCanUpdateAnBrand(): void
    {
        $brand = Brand::factory()->create();
        $data = ['name' => 'New name'];
        $updatedBrand = $this->brandRepository->updateBrand($brand, $data);
        $this->assertInstanceOf(Brand::class, $updatedBrand);
        $this->assertEquals($data['name'], $updatedBrand->name);
        $this->assertDatabaseHas('brands', ['id' => $brand->id]);
    }

    // Delete address tests

    public function testItCanSoftDeleteAnBrand(): void
    {
        $brand = Brand::factory()->create();
        $result = $this->brandRepository->softDeleteBrand($brand);
        $this->assertTrue($result);
        $this->assertSoftDeleted('brands', ['id' => $brand->id]);
    }

    public function testItCanForceDeleteAnBrand(): void
    {
        $brand = Brand::factory()->create();
        $result = $this->brandRepository->forceDeleteBrand($brand);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function testItCanForceDeleteASoftDeletedBrand(): void
    {
        $brand = Brand::factory()->create();
        $this->brandRepository->softDeleteBrand($brand);
        $result = $this->brandRepository->forceDeleteBrand($brand);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function testItCanRestoreASoftDeletedBrand(): void
    {
        $brand = Brand::factory()->create();
        $this->brandRepository->softDeleteBrand($brand);
        $result = $this->brandRepository->restoreBrand($brand);
        $this->assertTrue($result);
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedAdress(): void
    {
        $this->expectException(\LogicException::class);
        $brand = Brand::factory()->create();
        $this->brandRepository->restoreBrand($brand);
    }
}
