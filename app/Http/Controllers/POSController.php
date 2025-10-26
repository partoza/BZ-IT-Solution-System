<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Customer;

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

        // Search by product_name
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
                    'price'       => (float) $displayPrice,          
                    'stock_count' => $items->count(),                 
                    'image'       => $product->image ?? null,
                    'brand'       => $product->brand->name ?? null,
                    'brand_id'    => $product->brand_id ?? null,
                    'category'    => $product->category->name ?? null,
                    'category_id' => $product->category_id ?? null,
                ];
            })
            // preserve collection indexing for blade loops (optional)
            ->values();

        // AJAX live filtering:
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

    public function checkout(Request $request)
    {
        try {
            // For form-based submission
            $rawCart = $request->input('cartData');
            $cartItems = $rawCart ? json_decode($rawCart, true) : $request->input('cart', []);

            $productIds = collect($cartItems)->pluck('id')->toArray();

            if (empty($productIds)) {
                Log::warning('No products in cart.');
                return redirect()->back()->with('error', 'No products in cart.');
            }

            $branchId = auth()->user()->branch_id;
            Log::info('Branch ID: ' . $branchId);

            $inventoryItems = InventoryItem::with(['product.brand', 'product.category'])
                ->where('branch_id', $branchId)
                ->where('status', 'in_stock')
                ->whereIn('product_id', $productIds)
                ->get();

            Log::info('Inventory count: ' . $inventoryItems->count());

            $products = $inventoryItems
                ->groupBy('product_id')
                ->map(function ($items) use ($cartItems) {
                    $inventorySample = $items->first();
                    $product = $inventorySample->product;

                    $cartItem = collect($cartItems)->firstWhere('id', $product->product_id);
                    $quantity = $cartItem['qty'] ?? 1;

                    // For non-serialized items, pick unit_price from any in-stock inventory item
                    $unitPrice = $product->track_serials
                        ? 0 // serialized items: price set after serial validation in JS
                        : $items->first()->unit_price; // non-serialized: take first available

                    return [
                        'product_id'   => $product->product_id,
                        'name'         => $product->product_name,
                        'description'  => $product->description ?? '',
                        'price'        => (float) $unitPrice,
                        'quantity'     => $quantity,
                        'subtotal'     => $unitPrice * $quantity,
                        'stock_count'  => $items->count(),
                        'image'        => $product->image ?? null,
                        'brand'        => $product->brand->name ?? null,
                        'category'     => $product->category->name ?? null,
                        'track_serial' => $product->track_serials ?? false,
                    ];
                })
                ->values();
            return view('nonmenu.pos.checkout', [
                'cartProducts' => $products,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Checkout failed. ' . $e->getMessage());
        }
    }
    

    public function validateSerials(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'serials' => 'required|array',
            'serials.*' => 'required|string',
        ]);

        $productId = $request->product_id;
        $serials = $request->serials;
        $branchId = auth()->guard('employee')->user()?->branch_id;

        \Log::info('ValidateSerials called', [
            'branch_id' => $branchId,
            'product_id' => $productId,
            'serials_received' => $serials
        ]);

        $invalid = [];
        $alreadySold = [];

        foreach ($serials as $serial) {
            $serialTrimmed = trim($serial);

            \Log::info('Checking serial', ['serial' => $serialTrimmed]);

            $item = InventoryItem::where('branch_id', $branchId)
                ->where('product_id', $productId)
                ->where('serial_number', $serialTrimmed)
                ->first();

            if (!$item) {
                $invalid[] = $serialTrimmed;
                \Log::warning('Serial invalid', ['serial' => $serialTrimmed]);
            } elseif ($item->status !== 'in_stock') {
                $alreadySold[] = $serialTrimmed;
                \Log::warning('Serial already sold', ['serial' => $serialTrimmed, 'status' => $item->status]);
            } else {
                \Log::info('Serial valid', ['serial' => $serialTrimmed]);
            }
        }

        if ($invalid || $alreadySold) {
            $msg = '';
            if ($invalid) $msg .= 'Invalid serials: ' . implode(', ', $invalid) . '. ';
            if ($alreadySold) $msg .= 'Already sold: ' . implode(', ', $alreadySold);

            \Log::error('Serial validation failed', ['message' => $msg]);
            return response()->json(['success' => false, 'message' => $msg]);
        }

        // All serials valid, calculate total price
        $totalPrice = InventoryItem::where('branch_id', $branchId)
            ->where('product_id', $productId)
            ->whereIn('serial_number', array_map('trim', $serials))
            ->sum('unit_price');

        \Log::info('Serials validated successfully', ['totalPrice' => $totalPrice]);

        return response()->json([
            'success' => true,
            'updatedPrice' => $totalPrice
        ]);
    }
}
