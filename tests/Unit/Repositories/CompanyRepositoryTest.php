<?php

namespace Tests\Unit\Repositories;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CompanyRepository $companyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepository = new CompanyRepository();
    }

    // Find company by id tests.

    public function testItCanFindACompanyById(): void
    {
        $createdCompany = Company::factory()->create();
        $foundCompany = $this->companyRepository->findCompanyById($createdCompany->id);
        $this->assertNotNull($foundCompany);
        $this->assertInstanceOf(Company::class, $foundCompany);
        $this->assertEquals(1, $foundCompany->id);
    }

    public function testItReturnsNullWhenCompanyNotFound(): void
    {
        $foundCompany = $this->companyRepository->findCompanyById(999);
        $this->assertNull($foundCompany);
    }

    public function testItCanCreateACompany(): void
    {
        $data = Company::factory()->make()->toArray();
        $createdCompany = $this->companyRepository->createCompany($data);
        $this->assertInstanceOf(Company::class, $createdCompany);
        $this->assertDatabaseHas('companies', $data);
    }

    public function testItCanUpdateACompany(): void
    {
        $company = Company::factory()->create();
        $data = ['fantasy_name' => 'New Fantasy Name'];
        $updatedCompany = $this->companyRepository->updateCompany($company, $data);
        $this->assertInstanceOf(Company::class, $updatedCompany);
        $this->assertEquals($data['fantasy_name'], $updatedCompany->fantasy_name);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }

    public function testItCanSoftDeleteACompany(): void
    {
        $company = Company::factory()->create();
        $result = $this->companyRepository->softDeleteCompany($company);
        $this->assertTrue($result);
        $this->assertSoftDeleted('companies', ['id' => $company->id]);
    }

    public function testItCanForceDeleteACompany(): void
    {
        $company = Company::factory()->create();
        $result = $this->companyRepository->forceDeleteCompany($company);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function testItCanForceDeleteASoftDeletedCompany(): void
    {
        $company = Company::factory()->create();
        $this->companyRepository->softDeleteCompany($company);
        $result = $this->companyRepository->forceDeleteCompany($company);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function testItCanRestoreASoftDeletedUser(): void
    {
        $company = Company::factory()->create();
        $this->companyRepository->softDeleteCompany($company);
        $result = $this->companyRepository->restoreCompany($company);
        $this->assertTrue($result);
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'deleted_at' => null]);
    }

    public function testItThrowsLogicExceptionWhenRestoringNonSoftDeletedCompany(): void
    {
        $this->expectException(\LogicException::class);
        $company = Company::factory()->create();
        $this->companyRepository->restoreCompany($company);
    }
}
