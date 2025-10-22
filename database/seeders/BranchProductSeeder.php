<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BranchProduct;

class BranchProductSeeder extends Seeder
{
    public function run()
    {
        // Check if product 1 exists
        $product = \App\Models\Product::find(2);
        if (!$product) {
            // Product doesn't exist, skip seeding
            return;
        }

        $branches = \App\Models\Branch::all();

        foreach ($branches as $branch) {
            \App\Models\BranchProduct::firstOrCreate(
                ['branch_id' => $branch->branch_id, 'product_id' => $product->product_id],
                [
                    'quantity_in_stock' => rand(0, 20),
                    'low_stock_threshold' => 5,
                    'medium_stock_threshold' => 10,
                    'override_price' => null,
                ]
            );
        }
    }

}
