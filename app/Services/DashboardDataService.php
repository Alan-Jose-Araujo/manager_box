<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardDataService
{
    public function getThisYearStockMovementsGroupedByMonthData()
    {
        $companyId = Auth::user()->company_id;
    }

    public function getItemsCountByCategoryData()
    {
        $companyId = Auth::user()->company_id;
        $results = DB::table('item_in_stock_categories as c')
            ->select(
                'c.id as category_id',
                'c.name as category_name',
                'c.color_hex_code as color_code',
                DB::raw('COUNT(ic.item_in_stock_id) as items_count')
            )
            ->leftJoin('item_in_stock_has_category as ic', 'ic.item_in_stock_category_id', '=', 'c.id')
            ->where('c.company_id', $companyId)
            ->groupBy('c.id', 'c.name', 'c.color_hex_code')
            ->orderByDesc('items_count')
            ->limit(10)
            ->get();

        return $results;
    }

    public function getAveragePriceByCategoryData()
    {
        $companyId = Auth::user()->company_id;
        $results = DB::table('item_in_stock_categories as c')
            ->select(
                'c.id as category_id',
                'c.name as category_name',
                'c.color_hex_code as color_code',
                DB::raw('AVG(stock.sale_price) as average_sale_price')
            )->leftJoin('item_in_stock_has_category as ic', 'ic.item_in_stock_category_id', '=', 'c.id')
            ->join('items_in_stock as stock', 'ic.item_in_stock_category_id', '=', 'stock.id')
            ->where('c.company_id', $companyId)
            ->groupBy('c.id', 'c.name', 'c.color_hex_code')
            ->orderByDesc('average_sale_price')
            ->limit(5)
            ->get();

        return $results;
    }

}
