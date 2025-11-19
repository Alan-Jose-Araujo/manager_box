<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemInStockCategoryService;
use Exception;
use Illuminate\Support\Facades\Log;

class ItemInStockCategoryController extends Controller
{

     private ItemInStockCategoryService $itemInStockCategoryService;

    public function __construct(ItemInStockCategoryService $itemInStockCategoryService)
    {
        $this->itemInStockCategoryService = $itemInStockCategoryService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->array('filters');
            $perPage = $request->input('per_page', config('pagination.default_items_per_page'));
            $itemInStockCategories = $this->itemInStockCategoryService->index($filters, $perPage);
            return response()->json([
                'success' => true,
                'categories' => $itemInStockCategories,
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scope' => 'required|string',
            'color_hex_code' => 'nullable|string|size:7',
            'is_active' => 'boolean',
            'company_id' => 'required|integer|exists:companies,id',
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',
        ]);

        $category = $this->itemInStockCategoryService->create($data);
        return response()->json(
            ['success' => true,
        'categoria' => $category], 201);
    }

    public function show(string $id)
    {
         $category = $this->itemInStockCategoryService->find($id);
        if (!$category) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true,
        'categoria' => $category], 200);
    }

    public function update(Request $request, string $id)
    {
         $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'scope' => 'sometimes|string',
            'color_hex_code' => 'nullable|string|size:7',
            'is_active' => 'boolean',
        ]);

        $category = $this->itemInStockCategoryService->update($id, $data);
        if (!$category) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true,
        'categoria' => $category], 201);
    }

    public function destroy(string $id)
    {
       $deleted = $this->itemInStockCategoryService->softDelete($id);
        if (!$deleted) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true], 201);
    }

    public function restore($id)
    {
        $restored = $this->itemInStockCategoryService->restore($id);
        if (!$restored) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true], 201);
    }
}
