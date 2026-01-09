<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\ItemInStockCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardDataService
{
    public function getMonthlyCheckoutsGroupedByCategoryData()
    {
        $companyId = Auth::user()->company_id;
        $startOfTheMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfTheMonth = Carbon::now()->endOfMonth()->toDateTimeString();
        $results = DB::table('item_in_stock_categories as c')
            ->select(
                'c.name as category_name',
                'c.color_hex_code as category_color',
                DB::raw('SUM(m.quantity_moved) as total_quantity_moved')
            )->join('item_in_stock_categories as c', 'ic.item_in_stock_category_id', '=', 'c.id')
            ->join('items_in_stock as i', 'i.id', '=', 'ic.item_in_stock_id')
            ->join('item_in_stock_movements as m', 'm.item_in_stock_id', '=', 'i.id')
            ->where('m.company_id', $companyId)
            ->where('m.movement_type', StockMovementType::CHECKOUT->value)
            ->where('m.created_at', '>=', $startOfTheMonth)
            ->where('m.created_at', '<=', $endOfTheMonth)
            ->groupBy(
                'c.id',
                'c.name',
                'c.color_hex_code'
            )->orderBy('total_quantity_moved', 'desc')
            ->get();
        return $results;
    }

    public function getKPIReportsData()
    {
        $authUser = Auth::user();
        $authCompany = $authUser->company;
        $totalOfItems = $authCompany->itemsInStock()->count();
        $totalOfCategories = $authCompany->itemInStockCategories()->count();
        $totalStockValue = $authCompany->itemsInStock->reduce(function ($carry, $item) {
            return $carry + ($item->cost_price ?? 0);
        }, 0);

        return [
            'total_of_items' => $totalOfItems,
            'total_of_categories' => $totalOfCategories,
            'total_stock_value' => $totalStockValue,
            // 'total_stock_value' => 0,
        ];
    }

    public function getWeeklyStockTurnoverData()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $companyId = Auth::user()->company_id;
        $getResults = fn(StockMovementType $stockMovementType) =>
            DB::table('item_in_stock_movements as movements')
                ->select(
                    DB::raw('SUM(movements.quantity_moved) as quantity_moved')
                )->where(
                    'movements.company_id',
                    $companyId,
                )
                ->where(
                    'movements.movement_type',
                    '=',
                    $stockMovementType->value
                )->whereBetween(
                    'movements.created_at',
                    [
                        $startOfWeek,
                        $endOfWeek
                    ]
                )->get()
                ->first()
                ->quantity_moved;

        $checkinMovedQuantity = $getResults(StockMovementType::CHECKIN);
        $checkoutMovedQuantity = $getResults(StockMovementType::CHECKOUT);

        return [
            'checkin' => (float) $checkinMovedQuantity,
            'checkout' => (float) $checkoutMovedQuantity
        ];
    }

    public function getThisYearStockMovementsGroupedByMonthData(StockMovementType $movementType)
    {
        $companyId = Auth::user()->company_id;
        $firstDayOfYearDate = Carbon::parse('first day of January this year')->format('Y-m-d');
        $lastDayOfYearDate = Carbon::parse('last day of December this year')->format('Y-m-d');
        $results = DB::table('item_in_stock_movements as movements')
            ->select(
                DB::raw('MONTH(movements.created_at) as movement_month'),
                DB::raw('SUM(movements.quantity_moved) as quantity_moved'),
            )->where(
                'movements.company_id',
                $companyId,
            )->where(
                'movements.movement_type',
                $movementType->value
            )->whereBetween(
                'movements.created_at',
                [
                    $firstDayOfYearDate,
                    $lastDayOfYearDate,
                ]
            )->groupBy(
                'movement_month',
            )->orderBy(
                'movement_month'
            )->get();

        return $results;
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
