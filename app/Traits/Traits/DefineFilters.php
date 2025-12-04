<?php

namespace App\Traits\Traits;

trait DefineFilters
{
    /**
     * @param mixed $query
     * @param array<string, mixed> $filters ['column' => ['operator', 'value', 'logical'?]]
     * @return mixed
     */
    private function applyFilters(&$query, array $filters)
    {
        if(!empty($filters)) {
            foreach($filters as $column => $searchValues) {
                if(!isset($searchValues['logical']) || (isset($searchValues['logical']) && $searchValues['logical'] == 'and')) {
                    $query->where($column, $searchValues['operator'], $searchValues['value']);
                } else if(isset($searchValues['logical']) && $searchValues['logical'] == 'or') {
                    $query->orWhere($column, $searchValues['operator'], $searchValues['value']);
                }
            }
        }
    }
}
