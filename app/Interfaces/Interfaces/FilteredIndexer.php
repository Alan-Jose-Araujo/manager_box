<?php

namespace App\Interfaces\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface FilteredIndexer
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
