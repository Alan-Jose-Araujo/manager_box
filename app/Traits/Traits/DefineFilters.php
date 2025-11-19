<?php

namespace App\Traits\Traits;

trait DefineFilters
{
    /**
     * @param mixed $query
     * @param array<string, mixed> $filters ['column' => ['operator', 'value']]
     * @return mixed
     */
    private function applyFilters(&$query, array $filters)
    {
        if(!empty($filters)) {
            foreach($filters as $column => $searchValues) {
                $query->where($column, $searchValues['operator'], $searchValues['value']);
            }
        }
    }
}
