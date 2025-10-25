<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\InventoryItem;
use App\Models\Branch;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $branchId = auth()->guard('employee')->user()?->branch_id;
        $perPage = intval($request->query('per_page', 10));

        // Filters
        $search = $request->query('search');
        $status = $request->query('status');
        $category = $request->query('category');
        $subCategory = $request->query('sub_category');
        $stockLevel = $request->query('stock');

        // Categories
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        $subCategories = $category
            ? Category::where('parent_id', $category)->orderBy('name')->get()
            : null;

        // Base query with relationships.
        // Add withCount to compute branch-specific in-stock instrument count
        $query = Product::with([
                'brand',
                'category',
                'subCategory',
                // eager-load branch pivot restricted to current branch (if exists)
                'branches' => function ($q) use ($branchId) {
                    $q->where('branch_product.branch_id', $branchId);
                },
                // eager-load inventory items for current branch (keeps collection small)
                'inventoryItems' => function ($q) use ($branchId) {
                    $q->where('inventory_items.branch_id', $branchId)
                    ->where('inventory_items.status', 'in_stock');
                },
            ])
            ->withCount([
                // this produces `branch_in_stock_count` available for filtering/having
                'inventoryItems as branch_in_stock_count' => function ($q) use ($branchId) {
                    $q->where('inventory_items.branch_id', $branchId)
                    ->where('inventory_items.status', 'in_stock');
                }
            ]);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($status) {
            $query->where('active_status', $status === 'Active');
        }

        // Category / subcategory filter
        if ($category) $query->where('category_id', $category);
        if ($subCategory) $query->where('sub_category_id', $subCategory);

        // Stock level filter: use HAVING on the counted column (branch_in_stock_count)
        if ($stockLevel) {
            switch ($stockLevel) {
                case 'High':
                    // more than medium threshold (choose 10, adjust as needed)
                    $query->having('branch_in_stock_count', '>', 10);
                    break;
                case 'Low':
                    // between 1 and medium threshold
                    $query->having('branch_in_stock_count', '<=', 10)
                        ->having('branch_in_stock_count', '>', 0);
                    break;
                case 'Out':
                    $query->having('branch_in_stock_count', '=', 0);
                    break;
            }
        }

        // Paginate - having will be applied by DB
        $products = $query->orderBy('product_name')->paginate($perPage)->appends($request->query());

        // Compute branch-specific info per product (use branch_in_stock_count instead of counting)
        foreach ($products as $product) {
            $branchPivot = $product->branches->first()?->pivot;

            // Use the withCount value (DB computed)
            $product->stock_count = (int) ($product->branch_in_stock_count ?? 0);

            // low threshold from pivot or default
            $product->low_threshold = $branchPivot->low_stock_threshold ?? 10;

            // Price precedence:
            // 1) branch pivot override_price
            // 2) newest inventory item unit_price (last stocked)
            // 3) product base_price
            $product->branch_price = $branchPivot->override_price
                ?? $product->inventoryItems->sortByDesc('created_at')->first()?->unit_price
                ?? $product->base_price;
        }

        // Summary cards
        $totalProducts = Product::count();
        $activeProducts = Product::where('active_status', true)->count();
        $inactiveProducts = Product::where('active_status', false)->count();

        // lowStock summary: count products where branch stock <= branch pivot low_stock_threshold (default 10)
        // We'll load branch pivot when available and use its low_stock_threshold; otherwise default to 10
        $productsForLowStock = Product::with([
            'branches' => function ($q) use ($branchId) {
                $q->where('branch_product.branch_id', $branchId);
            }
        ])->withCount([
            'inventoryItems as branch_in_stock_count' => function ($q) use ($branchId) {
                $q->where('inventory_items.branch_id', $branchId)
                  ->where('inventory_items.status', 'in_stock');
            }
        ])->get();

        $lowStock = $productsForLowStock->filter(function ($product) {
            $stock = (int) ($product->branch_in_stock_count ?? 0);
            $threshold = 10; // default low threshold to match UI and per-product logic

            if ($product->relationLoaded('branches') && $product->branches->first() && $product->branches->first()->pivot) {
                $threshold = $product->branches->first()->pivot->low_stock_threshold ?? $threshold;
            }

            return $stock <= $threshold;
        })->count();

        return view('pages.inventory.products', compact(
            'products',
            'categories',
            'subCategories',
            'search',
            'status',
            'category',
            'subCategory',
            'stockLevel',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStock'
        ));
    }
    
    public function create()
    {
        $brands = Brand::orderBy('name')->get();

        // Only top-level categories
        $mainCategories = Category::where('status', 'Active')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('nonmenu.inventory.addproduct', compact('brands', 'mainCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'base_price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'active_status' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'warranty_period' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Create product
        $product = Product::create($validated);

        // Stock will only exist when P.O / inventory_items are created
        // No default branch stock creation needed

        return response()->json(['message' => 'Product created successfully!']);
    }
}
