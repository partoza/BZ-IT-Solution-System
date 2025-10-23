<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        // Filters / controls from UI
        $view = $request->query('view', 'categories'); // 'categories' or 'subcategories'
        $search = $request->query('search');
        $typeFilter = $request->query('type'); // 'product' or 'service' or null
        $statusFilter = $request->query('status'); // 'Active'|'Inactive'|null
        $perPage = intval($request->query('per_page', 15));

        // Pass categories collection for dropdowns (top-level parents etc.)
        // We order by name so dropdown is friendly.
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();

        // Base query: either top-level categories or subcategories
        $query = Category::query()
            ->withCount('products') // direct products count
            ->with(['children' => function ($q) {
                $q->withCount('products'); // children products count
            }]);

        if ($view === 'categories') {
            $query->whereNull('parent_id');
        } else { // subcategories
            $query->whereNotNull('parent_id');
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($typeFilter) {
            $query->where('category_type', $typeFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        // order and paginate
        $rows = $query->orderBy('name')->paginate($perPage)->appends($request->query());

        // compute derived metrics for displayed rows (per-page)
        $rows->getCollection()->transform(function (Category $cat) {
            $subcategoriesCount = $cat->children->count();
            $directProducts = $cat->products_count ?? 0;
            $childrenProductsTotal = $cat->children->sum('products_count');
            $totalProducts = $directProducts + $childrenProductsTotal;

            // product ids under this cat and its immediate children
            $productIds = $cat->products()->pluck('product_id')->toArray();
            if ($cat->children->isNotEmpty()) {
                $childIds = $cat->children->pluck('id')->toArray();
                $childProductIds = DB::table('products')->whereIn('category_id', $childIds)->pluck('product_id')->toArray();
                $productIds = array_merge($productIds, $childProductIds);
            }

            $inventoryValue = 0;
            if (!empty($productIds)) {
                $inventoryValue = (float) DB::table('inventory_items')
                    ->join('products', 'products.product_id', '=', 'inventory_items.product_id')
                    ->whereIn('inventory_items.product_id', $productIds)
                    ->where('inventory_items.status', 'in_stock')
                    ->selectRaw('COALESCE(SUM(inventory_items.unit_price), 0) as inventory_value')
                    ->value('inventory_value');
            }

            $cat->setAttribute('subcategories_count', $subcategoriesCount);
            $cat->setAttribute('direct_products_count', $directProducts);
            $cat->setAttribute('total_products_count', $totalProducts);
            $cat->setAttribute('inventory_value', $inventoryValue);

            return $cat;
        });

        // Dashboard summary
        $totalCategories = Category::whereNull('parent_id')->count();
        $totalSubcategories = Category::whereNotNull('parent_id')->count();
        $activeCategories = Category::where('status', 'Active')->count();
        $inactiveCategories = Category::where('status', 'Inactive')->count();

        // pass $categories to the view for dropdown use
        return view('pages.settings.categories', compact(
            'rows',
            'view',
            'search',
            'typeFilter',
            'statusFilter',
            'totalCategories',
            'totalSubcategories',
            'activeCategories',
            'inactiveCategories',
            'categories'           // <<-- added here
        ));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255|unique:categories,name',
            'description'   => 'nullable|string',
            'category_type' => 'required|in:product,service',
            'parent_id'     => 'nullable|exists:categories,id',
            'is_active'     => 'nullable|boolean',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // If a parent category is selected, automatically treat it as subcategory
        if ($request->filled('parent_id')) {
            $validated['category_type'] = 'subcategory';
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        // Set status
        $validated['status'] = $request->has('is_active') && $request->boolean('is_active')
            ? 'Active'
            : 'Inactive';

        // Add created by
        $validated['createdby_id'] = Auth::guard('employee')->id();

        Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully!',
        ], 200);
    }

    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)
            ->where('status', 'Active')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}
