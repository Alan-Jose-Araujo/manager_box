<?php

namespace App\Http\Controllers;

use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{

    private WarehouseService  $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->array('filters');
            $perPage = $request->input('per_page', config('pagination.default_items_per_page'));
            $warehouses = $this->warehouseService->index($filters, $perPage);
            return response()->json([
                'success' => true,
                'warehouses' => $warehouses,
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
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'company_id' => 'required|integer|exists:companies,id',
        ]);

        $warehouse = $this->warehouseService->create($data);
        return response()->json([
            'success' => true,
            'warehouse' => $warehouse,
        ], 200);
    }

    public function show(string $id)
    {
         $warehouse = $this->warehouseService->find($id);
         if (!$warehouse) {
            return response()->json([
                'success' => false,], 404);
         }
         return response()->json([
            'success' => true,
            'warehouse' => $warehouse,
        ]);
    }

    public function update(Request $request, string $id)
    {
            $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $warehouse = $this->warehouseService->update($id, $data);
           if (!$warehouse) {
            return response()->json([
                'success' => false,], 404);
        }
        return response()->json([
            'success' => true,
            'warehouse' => $warehouse,
        ]);
    }

    public function destroy(string $id)
    {
       $deleted = $this->warehouseService->softDelete($id);
        if (!$deleted) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true]);
    }

      public function restore($id)
    {
        $restored = $this->warehouseService->restore($id);
        if (!$restored) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true]);
    }
}
