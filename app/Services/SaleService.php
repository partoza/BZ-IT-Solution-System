<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryItem;
use App\Models\BranchProduct;
use Exception;

class SaleService
{
    /**
     * Create sale from inventory (by inventory_item_ids / serials OR by product qty)
     *
     * $payload = [
     *   'branch_id' => int,
     *   'employee_id' => int|null,
     *   'status' => 'completed'|'reserved',
     *   'items' => [
     *       // inventory allocation
     *       ['product_id'=>10, 'inventory_item_ids'=>[100,101], 'sold_prices'=>[100=>1200,101=>1200]],
     *       // or quantity allocation
     *       ['product_id'=>11, 'quantity'=>3, 'unit_price'=>600.00]
     *   ]
     * ]
     */
    public function createFromPayload(array $payload)
    {
        $branchId = $payload['branch_id'];
        $employeeId = $payload['employee_id'] ?? null;
        $status = $payload['status'] ?? 'completed';
        $items = $payload['items'] ?? [];

        if (empty($items)) {
            throw new Exception('No items provided');
        }

        return DB::transaction(function () use ($branchId, $employeeId, $status, $items) {

            // create sale header
            $sale = Sale::create([
                'sales_number' => $this->generateSalesNumber(),
                'branch_id' => $branchId,
                'employee_id' => $employeeId,
                'status' => $status,
                'sub_total' => 0,
                'grand_total' => 0,
                'sold_at' => $status === 'completed' ? now() : null,
                'createdby_id' => $employeeId,
            ]);

            $subTotal = 0;

            foreach ($items as $line) {
                if (!empty($line['inventory_item_ids'])) {
                    // explicit inventory rows mode
                    $invIds = $line['inventory_item_ids'];

                    $inventoryRows = InventoryItem::where('branch_id', $branchId)
                        ->whereIn('id', $invIds)
                        ->lockForUpdate()
                        ->get();

                    if ($inventoryRows->count() !== count($invIds)) {
                        throw new Exception('Some provided inventory items were not found for this branch.');
                    }

                    foreach ($inventoryRows as $inv) {
                        if (! in_array($inv->status, ['in_stock','reserved'])) {
                            throw new Exception("Inventory {$inv->serial_number} (id {$inv->id}) is not available (status={$inv->status}).");
                        }
                    }

                    $grouped = $inventoryRows->groupBy('product_id');

                    foreach ($grouped as $productId => $rows) {
                        $quantity = $rows->count();
                        $lineTotal = 0;

                        foreach ($rows as $inv) {
                            $soldPrice = $line['sold_prices'][$inv->id] ?? $inv->unit_price;
                            $lineTotal += (float) $soldPrice;
                        }

                        $unitPrice = $quantity ? ($lineTotal / $quantity) : 0;

                        $saleItem = SaleItem::create([
                            'sale_id' => $sale->id,
                            'product_id' => $productId,
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                            'line_total' => $lineTotal,
                            'is_serialized' => true,
                        ]);

                        foreach ($rows as $inv) {
                            $soldPrice = $line['sold_prices'][$inv->id] ?? $inv->unit_price;
                            $inv->status = ($status === 'completed') ? 'sold' : 'reserved';
                            $inv->sale_id = $sale->id;
                            $inv->sale_item_id = $saleItem->id;
                            $inv->sold_price = $soldPrice;
                            $inv->sold_at = ($status === 'completed') ? now() : null;
                            $inv->updatedby_id = $employeeId;
                            $inv->save();
                        }

                        $subTotal += $lineTotal;
                        $this->updateBranchProductStats($branchId, $productId, $quantity, $status);
                    }
                } else {
                    // allocation-by-quantity mode
                    $productId = $line['product_id'] ?? null;
                    $qty = intval($line['quantity'] ?? 0);
                    $unitPriceOverride = $line['unit_price'] ?? null;

                    if (! $productId || $qty <= 0) {
                        throw new Exception('Invalid product/quantity for a line.');
                    }

                    $inventoryQuery = InventoryItem::where('branch_id', $branchId)
                        ->where('product_id', $productId)
                        ->whereIn('status', ['in_stock','reserved'])
                        ->orderBy('id','asc')
                        ->lockForUpdate()
                        ->limit($qty);

                    $selected = $inventoryQuery->get();

                    if ($selected->count() < $qty) {
                        throw new Exception("Not enough stock for product_id {$productId} in branch {$branchId}. Requested {$qty}, available {$selected->count()}.");
                    }

                    $lineTotal = 0;
                    foreach ($selected as $inv) {
                        $soldPrice = $unitPriceOverride ?? $inv->unit_price;
                        $lineTotal += (float) $soldPrice;
                    }
                    $unitPrice = $qty ? ($lineTotal/$qty) : 0;

                    $saleItem = SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'line_total' => $lineTotal,
                        'is_serialized' => true,
                    ]);

                    foreach ($selected as $inv) {
                        $soldPrice = $unitPriceOverride ?? $inv->unit_price;
                        $inv->status = ($status === 'completed') ? 'sold' : 'reserved';
                        $inv->sale_id = $sale->id;
                        $inv->sale_item_id = $saleItem->id;
                        $inv->sold_price = $soldPrice;
                        $inv->sold_at = ($status === 'completed') ? now() : null;
                        $inv->updatedby_id = $employeeId;
                        $inv->save();
                    }

                    $subTotal += $lineTotal;
                    $this->updateBranchProductStats($branchId, $productId, $qty, $status);
                }
            }

            // finalize totals
            $sale->sub_total = $subTotal;
            $sale->grand_total = $subTotal;
            $sale->save();

            return $sale->fresh();
        });
    }

    protected function updateBranchProductStats($branchId, $productId, $qty, $status)
    {
        if (!class_exists(BranchProduct::class)) return;

        $bp = BranchProduct::where('branch_id', $branchId)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->first();

        if (! $bp) return;

        if ($status === 'completed') {
            $bp->quantity_in_stock = max(0, $bp->quantity_in_stock - $qty);
            if (isset($bp->reserved_quantity)) {
                $bp->reserved_quantity = max(0, $bp->reserved_quantity - $qty);
            }
        } else {
            if (isset($bp->reserved_quantity)) {
                $bp->reserved_quantity += $qty;
            }
        }
        $bp->save();
    }

    protected function generateSalesNumber()
    {
        return 'S' . now()->format('YmdHis') . rand(100,999);
    }
}
