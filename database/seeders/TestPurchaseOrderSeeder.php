<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\InventoryItem;
use App\Models\Branch;

class TestPurchaseOrderSeeder extends Seeder
{
    public function run()
    {
        // Default branch for testing
        $branchId = auth()->guard('employee')->user()?->branch_id ?? 1;

        // Only existing products (product_id 1 and 2)
        $products = Product::whereIn('product_id', [1, 2])->get();
        if ($products->isEmpty()) {
            // No products exist, skip seeding
            return;
        }

        // Ensure branch exists
        $branch = Branch::find($branchId);
        if (!$branch) return;

        // Ensure supplier exists
        $supplier = Supplier::first();
        if (!$supplier) return;

        // Unique PO number
        $poNumber = 'PO-' . now()->format('YmdHis');

        $po = PurchaseOrder::create([
            'po_number' => $poNumber,
            'supplier_id' => $supplier->id,
            'status' => 'received', // simulate stock-in
        ]);

        foreach ($products as $product) {
            $quantity = rand(3, 10); // random quantity per product
            $unitPrice = $product->base_price + rand(5, 50); // random markup per P.O

            // Create Purchase Order Item
            $poItem = PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'product_id' => $product->product_id,
                'branch_id' => $branchId,
                'quantity_ordered' => $quantity,
                'unit_price' => $unitPrice,
            ]);

            // Create individual Inventory Items
            for ($i = 0; $i < $quantity; $i++) {
                $serialNumber = strtoupper(Str::random(10));

                if (!InventoryItem::where('product_id', $product->product_id)
                    ->where('branch_id', $branchId)
                    ->where('serial_number', $serialNumber)
                    ->exists()) 
                {
                    InventoryItem::create([
                        'product_id' => $product->product_id,
                        'branch_id' => $branchId,
                        'purchase_order_item_id' => $poItem->id, // ✅ LINK IT HERE
                        'serial_number' => $serialNumber,
                        'unit_price' => $unitPrice,
                        'status' => 'in_stock'
                    ]);
                }
            }
        }
    }
}
