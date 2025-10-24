<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Brand;

class POSController extends Controller
{
    /**
     * Display the POS product catalog (inventory-driven).
     *
     * Uses unit_price from inventory_items as the displayed price.
     */
    public function index(Request $request)
    {
        $branchId = auth()->user()->branch_id; // current user's branch

        // Fetch parent categories with children for tabs
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        // Fetch brands for filters
        $brands = Brand::orderBy('name')->get();

        // Base inventory query: in-stock items at this branch
        $inventoryQuery = InventoryItem::with(['product.category', 'product.brand'])
            ->where('branch_id', $branchId)
            ->where('status', 'in_stock');

        //
        // Apply filters (category, brand, search)
        //

        // Category filter — include selected parent and its direct children
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;

            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id');

            $inventoryQuery->whereHas('product', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $inventoryQuery->whereHas('product', function ($q) use ($request) {
                $q->where('brand_id', $request->brand_id);
            });
        }

        // Search by product_name or SKU (if you have sku on products)
        if ($request->filled('search')) {
            $search = $request->search;
            $inventoryQuery->whereHas('product', function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%");
            });
        }

        // Fetch filtered inventory items
        $inventoryItems = $inventoryQuery->get();

        /**
         * Group inventory items by product_id so we show one catalog entry per product.
         * Use the lowest available unit_price among the grouped inventory items as the displayed price.
         */
        $products = $inventoryItems
            ->groupBy('product_id')
            ->map(function ($items) {
                $inventorySample = $items->first();
                $product = $inventorySample->product;

                // pick the lowest unit_price among available inventory units for display
                $displayPrice = $items->min('unit_price');

                return [
                    // keys expected by the blade partial
                    'product_id'  => $product->product_id,
                    'name'        => $product->product_name,
                    'description' => $product->description ?? '',
                    'price'       => (float) $displayPrice,           // unit_price from inventory_items
                    'stock_count' => $items->count(),                 // number of inventory units available
                    'image'       => $product->image ?? null,
                    'brand'       => $product->brand->name ?? null,
                    'brand_id'    => $product->brand_id ?? null,
                    'category'    => $product->category->name ?? null,
                    'category_id' => $product->category_id ?? null,
                ];
            })
            // preserve collection indexing for blade loops (optional)
            ->values();

        // AJAX live filtering: return only the product grid partial
        if ($request->ajax()) {
            return view('partials.product-grid', ['products' => $products])->render();
        }

        // Full page load
        return view('pages.dashboard.point-of-sales', [
            'categories' => $categories,
            'brands'     => $brands,
            'products'   => $products,
        ]);
    }
}
