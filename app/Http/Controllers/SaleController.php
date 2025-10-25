<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SaleService;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,branch_id',
            'employee_id' => 'nullable|exists:employees,employee_id',
            'status' => ['nullable', Rule::in(['completed','reserved'])],
            'items' => 'required|array|min:1',

            // item validation: either inventory_item_ids OR product_id+quantity
            'items.*.inventory_item_ids' => 'nullable|array',
            'items.*.inventory_item_ids.*' => 'integer|distinct',
            'items.*.sold_prices' => 'nullable|array',
            'items.*.sold_prices.*' => 'nullable|numeric|min:0',

            'items.*.product_id' => 'nullable|exists:products,product_id',
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
        ]);

        try {
            $sale = $this->saleService->createFromPayload($data);
            return response()->json(['success' => true, 'sale' => $sale], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
