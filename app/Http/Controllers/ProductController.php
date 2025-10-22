<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\BranchProduct;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $branchId = auth()->guard('employee')->user()?->branch_id;
        $perPage = intval($request->query('per_page', 10));
        
        // Filters from request
        $search = $request->query('search');
        $status = $request->query('status');
        $category = $request->query('category');
        $subCategory = $request->query('sub_category'); // new
        $stockLevel = $request->query('stock');

        // Category list for filters
        $categories = Category::whereNull('parent_id')->orderBy('name')->get(); // only top-level

        // Subcategories for the selected category
        $subCategories = null;
        if ($category) {
            $subCategories = Category::where('parent_id', $category)->orderBy('name')->get();
        }

        // Base query with eager load for branch pivot
        $query = Product::with([
            'brand',
            'category',
            'subCategory', // make sure you have this relation defined
            'branches' => function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            }
        ]);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                ->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        // Apply status filter
        if ($status) {
            $query->where('active_status', $status === 'Active' ? true : false);
        }

        // Apply category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        // Apply subcategory filter
        if ($subCategory) {
            $query->where('sub_category_id', $subCategory);
        }

        // Apply stock level filter using pivot
        if ($stockLevel) {
            $query->whereHas('branches', function ($q) use ($branchId, $stockLevel) {
                $q->where('branch_product.branch_id', $branchId);

                switch ($stockLevel) {
                    case 'High':
                        $q->whereRaw('branch_product.quantity_in_stock > branch_product.medium_stock_threshold');
                        break;
                    case 'Low':
                        $q->whereRaw('branch_product.quantity_in_stock <= branch_product.medium_stock_threshold')
                        ->whereRaw('branch_product.quantity_in_stock > 0');
                        break;
                    case 'Out':
                        $q->where('branch_product.quantity_in_stock', 0);
                        break;
                }
            });
        }

        // Paginate results
        $products = $query->with(['brand', 'category', 'branches' => function($q) use ($branchId) {
                $q->where('branch_product.branch_id', $branchId);
            }])
            ->orderBy('product_name')
            ->paginate($perPage)
            ->appends($request->query());

        // Summary cards
        $totalProducts = Product::count();
        $activeProducts = Product::where('active_status', true)->count();
        $inactiveProducts = Product::where('active_status', false)->count();
        $lowStock = BranchProduct::where('branch_product.branch_id', $branchId)
            ->whereColumn('quantity_in_stock', '<=', 'low_stock_threshold')
            ->count();

        return view('pages.inventory.products', compact(
            'products',
            'categories',
            'subCategories', // new
            'search',
            'status',
            'category',
            'subCategory', // new
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

        // Only top-level categories (no parent)
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

        // Safety check like seeder
        if ($product && $product->product_id) {
            $branches = Branch::all();
            foreach ($branches as $branch) {
                BranchProduct::firstOrCreate(
                    ['branch_id' => $branch->branch_id, 'product_id' => $product->product_id],
                    [
                        'quantity_in_stock' => 0,
                        'low_stock_threshold' => 5,
                        'medium_stock_threshold' => 10,
                        'override_price' => null,
                    ]
                );
            }
        }

        return response()->json(['message' => 'Product created successfully!']);
    }
}
