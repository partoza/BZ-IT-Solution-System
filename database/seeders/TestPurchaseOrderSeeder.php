<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\BranchProduct;
use App\Models\Product;

class TestPurchaseOrderSeeder extends Seeder
{
    public function run()
    {
        // Default branch for testing (auth employee's branch or fallback)
        $branchId = auth()->guard('employee')->user()?->branch_id ?? 1;

        // Create a test supplier (repeatable)
        $supplier = Supplier::firstOrCreate(
            ['company_name' => 'Test Supplier'],
            [
                'contact_person' => 'John Doe',
                'email' => 'test@supplier.com',
                'phone_number' => '09123456789',
                'address' => '123 Test St, City',
                'notes' => 'Seeder test supplier'
            ]
        );

        // Create a unique PO tied to the supplier
        $poNumber = 'PO-' . now()->format('YmdHis');
        $po = PurchaseOrder::create([
            'po_number' => $poNumber,
            'supplier_id' => $supplier->id,
            'status' => 'received', // simulate stock-in
        ]);

        // Get the products to include in this PO
        $products = Product::whereIn('product_id', [1,2])->get();

        foreach ($products as $product) {
            // Generate a random quantity for this item
            $quantity = rand(5, 15);

            // Create the PO item
            $poItem = PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'product_id' => $product->product_id,
                'quantity_ordered' => $quantity,
                'branch_id' => $branchId,
            ]);

            // Stock in to branch_product
            BranchProduct::updateOrCreate(
                [
                    'branch_id' => $branchId,
                    'product_id' => $product->product_id
                ],
                [
                    'quantity_in_stock' => DB::raw("quantity_in_stock + {$quantity}"),
                    'low_stock_threshold' => 5,
                    'medium_stock_threshold' => 10
                ]
            );
        }
    }
}
