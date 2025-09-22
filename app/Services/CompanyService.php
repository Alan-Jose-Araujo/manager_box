<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Traits\UploadFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    use UploadFiles;

    private CompanyRepository $companyRepository;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
    }

    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Company|\Illuminate\Database\Eloquent\Builder<Company>
     */
    public function find(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Company
    {
        return $this->companyRepository->findCompanyById($id, $includeTrashed, $columns);
    }

    /**
     * @param array $data
     * @return Company
     */
    public function create(array $data): Company
    {
        if (isset($data['logo_picture_path']) && $data['logo_picture_path'] instanceof UploadedFile) {
            $uploadedFile = $data['logo_picture_path'];
            $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'company_logo_pictures');
            $data['logo_picture_path'] = $filePath;
        }
        return $this->companyRepository->createCompany($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Company|null
     */
    public function update(int $id, array $data): ?Company
    {
        $company = $this->companyRepository->findCompanyById($id);
        if (!$company) {
            return null;
        }
        unset($data['logo_picture_profile']);
        return $this->companyRepository->updateCompany($company, $data);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @return Company|null
     */
    public function updateLogoPicture(int $id, UploadedFile $uploadedFile): ?Company
    {
        $company = $this->companyRepository->findCompanyById($id);
        if (!$company) {
            return null;
        }
        $filePath = $this->storeFileAndGetPath($uploadedFile, 'public', 'company_logo_pictures');
        $data['logo_picture_path'] = $filePath;

        if ($company->logo_picture_path) {
            Storage::disk('public')->delete('company_logo_pictures/' . basename($company->logo_picture_path));
        }
        return $this->companyRepository->updateCompany($company, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteProfilePicture(int $id): bool
    {
        $company = $this->companyRepository->findCompanyById($id);
        if (!$company) {
            return false;
        }
        Storage::disk('public')->delete('company_logo_pictures/' . basename($company->logo_picture_path));
        $data['logo_picture_path'] = null;
        $this->companyRepository->updateCompany($company, $data);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {
        $company = $this->companyRepository->findCompanyById($id);
        if (!$company) {
            return false;
        }
        return $this->companyRepository->softDeleteCompany($company);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $company = $this->companyRepository->findcompanyById($id, true);
        if (!$company) {
            return false;
        }
        if ($company->logo_picture_path) {
            Storage::disk('public')->delete('company_logo_pictures/' . basename($company->logo_picture_path));
        }
        return $this->companyRepository->forceDeletecompany($company);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $company = $this->companyRepository->findCompanyById($id, true);
        if(!$company) {
            return false;
        }
        return $this->companyRepository->restoreCompany($company);
    }
}
