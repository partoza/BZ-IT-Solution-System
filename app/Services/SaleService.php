<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Product;

class SaleService
{
    public function store(array $data)
    {
        // Defensive check: ensure serialized products have serials
        $missing = [];

        foreach ($data['items'] as $item) {
            $productId = $item['product_id'];
            $qty = intval($item['quantity'] ?? 0);

            $product = Product::find($productId);
            $requiresSerial = false;

            if ($product) {
                // try common boolean column names
                if (isset($product->track_serial)) $requiresSerial = (bool) $product->track_serial;
                elseif (isset($product->requires_serial)) $requiresSerial = (bool) $product->requires_serial;
                elseif (isset($product->is_serialized)) $requiresSerial = (bool) $product->is_serialized;
            }

            // fallback heuristic: if there are inventory items for this product with a serial, treat as serialized
            if (!$requiresSerial) {
                $hasSerialInventory = InventoryItem::where('product_id', $productId)
                    ->whereNotNull('serial_number')
                    ->where('serial_number', '!=', '')
                    ->exists();
                if ($hasSerialInventory) $requiresSerial = true;
            }

            if ($requiresSerial) {
                $serials = $item['serial_numbers'] ?? [];
                $serialCount = is_array($serials) ? count(array_filter($serials, 'strlen')) : 0;

                if ($serialCount !== $qty) {
                    $missing[] = $product->product_name ?? $product->name ?? "Product ID {$productId}";
                }
            }
        }

        if (!empty($missing)) {
            return [
                'success' => false,
                'message' => 'Serial numbers required for: ' . implode(', ', $missing) . '.'
            ];
        }

        $branchId = auth()->guard('employee')->user()?->branch_id;
        DB::beginTransaction();

        try {
            // Generate sales number
            $salesNumber = 'S-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
            $branchId = auth()->guard('employee')->user()?->branch_id;
            $sale = Sale::create([
                'sales_number' => $salesNumber,
                'branch_id' => $branchId,
                'employee_id' => $data['employee_id'] ?? auth()->guard('employee')->user()?->employee_id,
                'customer_id' => $data['customer_id'] ?? null,
                'payment_method' => $data['payment_method'],
                'payment_reference' => $data['payment_reference'] ?? null,
                'status' => $data['status'] ?? 'completed',
                'sold_at' => now(),
                'createdby_id' => auth()->user()->employee_id ?? null,
            ]);

            $subTotal = 0;
            $discountTotal = 0;
            $taxTotal = 0;

            foreach ($data['items'] as $item) {
                $unitPrice = $item['unit_price'];
                $quantity = $item['quantity'];
                $discount = $item['line_discount'] ?? 0;
                $serialNumbers = $item['serial_numbers'] ?? [];

                $lineTotal = ($unitPrice * $quantity) - $discount;

                $saleItem = $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_discount' => $discount,
                    'tax' => 0,
                    'line_total' => $lineTotal,
                    'is_serialized' => !empty($serialNumbers),
                ]);

                $subTotal += $unitPrice * $quantity;
                $discountTotal += $discount;

                // 🔹 Update inventory
                if (!empty($serialNumbers)) {
                    foreach ($serialNumbers as $serial) {
                        InventoryItem::where('serial_number', $serial)
                            ->where('branch_id', $branchId)
                            ->where('product_id', $item['product_id'])
                            ->where('status', 'in_stock')
                            ->limit(1)
                            ->update([
                                'status' => 'sold',
                                'sale_id' => $sale->id,
                                'sale_item_id' => $saleItem->id,
                                'sold_price' => $unitPrice,
                                'sold_at' => now(),
                            ]);
                    }
                } else {
                    InventoryItem::where('branch_id', $branchId)
                        ->where('product_id', $item['product_id'])
                        ->where('status', 'in_stock')
                        ->limit($quantity)
                        ->update([
                            'status' => 'sold',
                            'sale_id' => $sale->id,
                            'sale_item_id' => $saleItem->id,
                            'sold_price' => $unitPrice,
                            'sold_at' => now(),
                        ]);
                }
            }

            $grandTotal = $subTotal - $discountTotal + $taxTotal;

            $sale->update([
                'sub_total' => $subTotal,
                'discount_total' => $discountTotal,
                'tax_total' => $taxTotal,
                'grand_total' => $grandTotal,
            ]);

            DB::commit();

            return [
                'success' => true,
                'sale' => $sale->fresh(['items']),
                'message' => 'Sale recorded successfully.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SaleService@store error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
