<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Services\CompanyService;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase;
    use UploadFiles;

    private CompanyService $companyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyService = new CompanyService();
    }

    // Find Company by ID tests.

    public function testItCanFindACompanyById(): void
    {
        $createdCompany = Company::factory()->create();
        $foundCompany = $this->companyService->find($createdCompany->id);
        $this->assertNotNull($foundCompany);
        $this->assertInstanceOf(Company::class, $foundCompany);
        $this->assertEquals($createdCompany->id, $foundCompany->id);
    }

    public function testItReturnsNullWhenCompanyNotFound(): void
    {
        $foundCompany = $this->companyService->find(999);
        $this->assertNull($foundCompany);
    }

    // Create Company tests.

    public function testItCanCreateACompanyWithoutLogoPicture(): void
    {
        $data = Company::factory()->make()->toArray();
        $createdCompany = $this->companyService->create($data);
        $this->assertInstanceOf(Company::class, $createdCompany);
        $this->assertDatabaseHas('companies', $data);
    }

    public function testItCanCreateACompanyWithProfilePicture(): void
    {
        $data = Company::factory()->make()->toArray();
        $data['logo_picture_path'] = $this->generateFakeFile([
            'name' => 'logo_picture.jpg',
            'mimeType' => 'image/jpg',
        ]);
        $createdCompany = $this->companyService->create($data);
        $data['logo_picture_path'] = $createdCompany->logo_picture_path;
        $this->assertInstanceOf(Company::class, $createdCompany);
        $this->assertDatabaseHas('companies', $data);
        $this->assertFileExists(
            storage_path('app/public/company_logo_pictures/' . basename($createdCompany->logo_picture_path))
        );
        Storage::disk('public')->delete('company_logo_pictures/' . basename($createdCompany->logo_picture_path));
    }

    // Update company tests.

    public function testItCanUpdateACompany(): void
    {
        $company = Company::factory()->create();
        $data = ['fantasy_name' => 'Updated fantasy name'];
        $updatedCompany = $this->companyService->update($company->id, $data);
        $this->assertNotNull($updatedCompany);
        $this->assertEquals($data['fantasy_name'], $updatedCompany->fantasy_name);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }

    public function testItCanUpdateACompanyLogoPicture(): void
    {
        $company = Company::factory()->create();
        $newLogoPicture = $this->generateFakeFile([
            'name' => 'new_logo_picture',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedCompany = $this->companyService->updateLogoPicture($company->id, $newLogoPicture);
        $this->assertNotNull($updatedCompany);
        $this->assertNotNull($updatedCompany->logo_picture_path);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
        $this->assertFileExists(
            storage_path('app/public/company_logo_pictures/' . basename($updatedCompany->logo_picture_path))
        );
        Storage::disk('public')->delete('company_logo_pictures/' . basename($updatedCompany->logo_picture_path));
    }

    public function testItCanUpdateCompanyLogoPictureReplacingOldOne(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $company = Company::factory()->create([
            'logo_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'company_logo_pictures')
        ]);
        $newLOgoPicture = $this->generateFakeFile([
            'name' => 'new_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $updatedCompany = $this->companyService->updateLogoPicture($company->id, $newLOgoPicture);
        $this->assertNotNull($updatedCompany);
        $this->assertNotNull($updatedCompany->logo_picture_path);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
        $this->assertFileExists(
            storage_path('app/public/company_logo_pictures/' . basename($updatedCompany->logo_picture_path))
        );
        Storage::disk('public')->delete('company_logo_pictures/' . basename($updatedCompany->logo_picture_path));
        Storage::disk('public')->delete('company_logo_pictures/' . basename($company->logo_picture_path));
    }

    public function testItCanDeleteACompanyLogoPicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_logo_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $company = Company::factory()->create([
            'logo_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'company_profile_pictures')
        ]);
        $result = $this->companyService->deleteProfilePicture($company->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/company_logo_pictures/' . basename($company->logo_picture_path))
        );
    }

    // Delete User tests.

    public function testItCanSoftDeleteACompany(): void
    {
        $company = Company::factory()->create();
        $result = $this->companyService->softDelete($company->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('companies', ['id' => $company->id]);
    }

    public function testItCanForceDeleteACompanyWithoutLogoPicture(): void
    {
        $company = Company::factory()->create();
        $result = $this->companyService->forceDelete($company->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function testItCanForceDeleteACompanyWithLogoPicture(): void
    {
        $initialFile = $this->generateFakeFile([
            'name' => 'initial_profile_picture.jpg',
            'mimeType' => 'image/jpeg',
        ]);
        $company = Company::factory()->create([
            'logo_picture_path' => $this->storeFileAndGetPath($initialFile, 'public', 'company_logo_pictures')
        ]);
        $result = $this->companyService->forceDelete($company->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
        $this->assertFileDoesNotExist(
            storage_path('app/public/company_logo_pictures/' . basename($company->logo_picture_path))
        );
    }

    public function testItCanRestoreASoftDeletedUser(): void
    {
        $company = Company::factory()->create();
        $this->companyService->softDelete($company->id);
        $result = $this->companyService->restore($company->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'deleted_at' => null]);
    }
}
