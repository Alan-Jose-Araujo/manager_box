<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemInStockService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItemInStockController extends Controller
{

    private ItemInStockService $itemInStockService;

    public function __construct(ItemInStockService $itemInStockService)
    {
        $this->itemInStockService = $itemInStockService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->array('filters');
            $perPage = $request->input('per_page', config('pagination.default_items_per_page'));
            $itemsInStock = $this->itemInStockService->index($filters, $perPage);
            return response()->json([
                'success' => true,
                'items_in_stock' => $itemsInStock
            ]);
        } catch(Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;

        $item = $this->itemInStockService->create($data);
        return response()->json([
            'success' => true,
            'item' => $item,
        ], 201);
    }

    public function show(string $id)
    {
      $item = $this->itemInStockService->find($id);
        if (!$item) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
            'item' => $item,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
           $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'trade_name' => 'nullable|string',
            'description' => 'nullable|string',
            'unity_of_measure' => 'sometimes|string',
            'quantity' => 'numeric',
            'minimum_quantity' => 'numeric',
            'maximum_quantity' => 'nullable|numeric',
            'cost_price' => 'numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        $item = $this->itemInStockService->update($id, $data);
        if (!$item) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(
            ['success' => true,
             'item' => $item,
            ], 201);
    }

    public function destroy(string $id)
    {
         $deleted = $this->itemInStockService->softDelete($id);
        if (!$deleted) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
        ], 201);
    }

    public function restore($id)
    {
        $restored = $this->itemInStockService->restore($id);
        if (!$restored) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
        ], 201);
    }
}
