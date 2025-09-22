<?php

namespace App\Repositories;

use App\Models\Company;
use LogicException;

class CompanyRepository
{
    /**
     * @param int $id
     * @param bool $includeTrashed
     * @param array $columns
     * @return Company|\Illuminate\Database\Eloquent\Builder<Company>
     */
    public function findCompanyById(int $id, bool $includeTrashed = false, array $columns = ['*']): ?Company
    {
        return Company::withTrashed()->find($id);
    }

    /**
     * @param array $data
     * @return Company
     */
    public function createCompany(array $data): Company
    {
        return Company::create($data);
    }

    /**
     * @param \App\Models\Company $company
     * @param array $data
     * @return Company
     */
    public function updateCompany(Company $company, array $data): Company
    {
        $company->update($data);
        return $company;
    }

    /**
     * @param \App\Models\Company $company
     * @return bool
     */
    public function softDeleteCompany(Company $company): bool
    {
        return (bool) $company->delete();
    }

    /**
     * @param \App\Models\Company $company
     * @return bool
     */
    public function forceDeleteCompany(Company $company): bool
    {
        return (bool) $company->forceDelete();
    }

    /**
     * @param \App\Models\Company $company
     * @throws \LogicException
     * @return bool
     */
    public function restoreCompany(Company $company): bool
    {
        if(!$company->deleted_at) {
            throw new LogicException('Cannot restore a company that is not deleted.');
        }
        return (bool) $company->restore();
    }
}
