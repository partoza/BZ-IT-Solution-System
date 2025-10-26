<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Branch;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Category;
use App\Models\Brand;
use App\Models\InventoryItem;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

        $branchId = auth()->guard('employee')->user()?->branch_id;
        $perPage = intval($request->query('per_page', 10));

        // Filters
        $search = $request->query('search');
        $status = $request->query('status');
        $supplierId = $request->query('supplier');

        // Fetch suppliers for filter dropdown
        $suppliers = Supplier::orderBy('company_name')->get();

        // Base query with relationships
        $query = PurchaseOrder::with(['supplier', 'items', 'creator']);

        // Apply search filter (PO number, supplier, product, or creator)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', fn($s) => $s->where('company_name', 'like', "%{$search}%"))
                    ->orWhereHas('items.product', fn($p) => $p->where('product_name', 'like', "%{$search}%"))
                    ->orWhereHas('items.inventoryItems', fn($inv) => $inv->where('serial_number', 'like', "%{$search}%"))
                    ->orWhereHas('creator', function ($creator) use ($search) {
                        $creator->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                    });
            });
        }

        // Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Supplier filter
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        // Pagination & ordering
        $purchase_orders = $query->orderBy('order_date', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Summary calculations
        $totalPOs = PurchaseOrder::count();
        $receivedPOs = PurchaseOrder::where('status', 'received')->count();
        $pendingPOs = PurchaseOrder::where('status', 'pending')->count();
        $partiallyReceivedPOs = PurchaseOrder::where('status', 'partial')->count();
        $totalOrdersLast30Days = PurchaseOrder::where('status', 'received')
            ->where('received_date', '>=', now()->subDays(30))
            ->count();

        //Weekly Activities
        $pendingThisWeek = PurchaseOrder::where('status', 'pending')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $completedThisWeek = PurchaseOrder::where('status', 'received')
            ->whereBetween('received_date', [$startOfWeek, $endOfWeek])
            ->count();

        $voidThisWeek = PurchaseOrder::where('status', 'void0')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        // Totals
        $totalPOsValue = \DB::table('purchase_order_items')
            ->selectRaw('SUM(unit_price * quantity_ordered) as total')
            ->value('total');

        $totalReceivedThisWeek = \DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
            ->where('purchase_orders.status', 'received')
            ->whereBetween('purchase_orders.received_date', [$startOfWeek, $endOfWeek])
            ->selectRaw('COALESCE(SUM(purchase_order_items.unit_price * purchase_order_items.quantity_ordered), 0) as total')
            ->value('total');

        $totalReceivedThisMonth = \DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
            ->where('purchase_orders.status', 'received')
            ->whereMonth('purchase_orders.received_date', now()->month)
            ->whereYear('purchase_orders.received_date', now()->year)
            ->selectRaw('SUM(purchase_order_items.unit_price * purchase_order_items.quantity_ordered) as total')
            ->value('total');

        $pendingPOValue = \DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
            ->where('purchase_orders.status', 'pending')
            ->selectRaw('SUM(purchase_order_items.unit_price * purchase_order_items.quantity_ordered) as total')
            ->value('total');

        $partialPOValue = \DB::table('purchase_orders')
            ->join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
            ->where('purchase_orders.status', 'partial')
            ->selectRaw('SUM(purchase_order_items.unit_price * purchase_order_items.quantity_ordered) as total')
            ->value('total');

        // Top supplier by total PO value
        $topSupplier = Supplier::with(['purchaseOrders.items'])
            ->get()
            ->map(function ($supplier) {
                $total = $supplier->purchaseOrders->flatMap->items
                    ->sum(fn($item) => $item->unit_price * $item->quantity_ordered);
                $supplier->total_value = $total;
                return $supplier;
            })
            ->sortByDesc('total_value')
            ->first();

        // Supplier summary counts
        $totalSuppliers = Supplier::count();
     //   $totalActiveSuppliers = Supplier::where('status', 'active')->count();

        return view('pages.history.purchase-order', compact(
            'purchase_orders',
            'suppliers',
            'search',
            'status',
            'supplierId',
            'perPage',
            'totalPOs',
            'receivedPOs',
            'pendingPOs',
            'partiallyReceivedPOs',
            'totalOrdersLast30Days',
            'totalPOsValue',
            'totalReceivedThisMonth',
            'pendingPOValue',
            'partialPOValue',
            'topSupplier',
            'pendingThisWeek',
            'completedThisWeek',
            'voidThisWeek',
            'totalReceivedThisWeek',
            'totalSuppliers',
           // 'totalActiveSuppliers',
        ));
    }


    public function create(Request $request)
    {
        $branchId = auth()->guard('employee')->user()?->branch_id;

        // Fetch all suppliers
        $suppliers = Supplier::orderBy('company_name')->get();

        // Fetch categories & brands (for filtering or future use)
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        $brands = Brand::orderBy('name')->get();

        // Base query: all products
        $productsQuery = Product::with([
            'category',
            'brand',
            'inventoryItems' => function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->where('status', 'in_stock');
            }
        ]);

        // Category filter
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;

            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id');

            $productsQuery->whereIn('category_id', $categoryIds);
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $productsQuery->where('brand_id', $request->brand_id);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $productsQuery->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%")
                    // also allow searching by brand or category names
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        // Discount filter: when 'discounted' param is truthy (e.g., 1), only include products
        // that have a discounted_price set and greater than zero.
        if ($request->filled('discounted') && $request->boolean('discounted')) {
            $productsQuery->whereNotNull('discounted_price')
                ->where('discounted_price', '>', 0);
        }

        // Discount filter: when 'discounted' param is truthy (e.g., 1), only include products
        // that have a discounted_price set and greater than zero.
        if ($request->filled('discounted') && $request->boolean('discounted')) {
            $productsQuery->whereNotNull('discounted_price')
                ->where('discounted_price', '>', 0);
        }

        $products = $productsQuery->get()->map(function ($product) {
            $inventory = $product->inventoryItems;

            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'description' => $product->description ?? '',
                'cost_price' => $inventory->min('unit_price') ?? 0,
                'base_price' => (float) ($product->price ?? $inventory->min('unit_price') ?? 0),
                'stock_count' => $inventory->count(),
                'image_url' => $product->image_url ?? null,
                'sku' => $product->sku ?? null,
                'brand' => $product->brand->name ?? null,
                'brand_id' => $product->brand_id ?? null,
                'category' => $product->category->name ?? null,
                'category_id' => $product->category_id ?? null,
            ];
        });

        // Handle AJAX requests
        if ($request->ajax()) {
            return view('partials.po-product-grid', ['products' => $products])->render();
        }

        // Full page load
        return view('pages.inventory.stock-in', [
            'suppliers' => $suppliers,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'branchId' => $branchId,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,branch_id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $branch = Branch::where('branch_id', $request->branch_id)->firstOrFail();

            // Generate PO number
            $poNumber = 'PO-' . now()->format('YmdHis');

            // Create PO record (default pending)
            $po = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $supplier->id,
                'status' => 'pending', // default
                'createdby_id' => auth()->guard('employee')->user()?->employee_id ?? null,
            ]);

            // Create PO items only
            foreach ($request->products as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item['product_id'],
                    'branch_id' => $branch->branch_id,
                    'quantity_ordered' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Purchase Order $poNumber created successfully!",
                'po_id' => $po->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function receive(Request $request, PurchaseOrder $po)
    {
        Log::info('Receive PO payload:', $request->all());

        $data = $request->validate([
            'items' => 'required|array',
            'items.*.po_item_id' => 'required|exists:purchase_order_items,id',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.serials' => 'nullable|array',
            'items.*.serials.*' => 'string|distinct',
            'items.*.markup' => 'required|numeric|min:0'
        ]);

        foreach ($data['items'] as $itemData) {
            $poItemId = $itemData['po_item_id'];
            $poItem = PurchaseOrderItem::find($poItemId);
            if (!$poItem)
                continue;

            $qty = $itemData['quantity'];
            $serials = $itemData['serials'] ?? [];
            $markupPercent = $itemData['markup'];
            $branchId = $poItem->branch_id ?? 1;

            // Calculate unit price with markup
            $unitPriceWithMarkup = $poItem->unit_price * (1 + ($markupPercent / 100));

            // Create inventory items
            if (count($serials) > 0) {
                foreach ($serials as $serial) {
                    \App\Models\InventoryItem::create([
                        'product_id' => $poItem->product_id,
                        'branch_id' => $branchId,
                        'purchase_order_item_id' => $poItemId,
                        'serial_number' => $serial,
                        'unit_price' => $unitPriceWithMarkup,
                        'status' => 'in_stock',
                    ]);
                }
            } else {
                for ($i = 0; $i < $qty; $i++) {
                    \App\Models\InventoryItem::create([
                        'product_id' => $poItem->product_id,
                        'branch_id' => $branchId,
                        'purchase_order_item_id' => $poItemId,
                        'unit_price' => $unitPriceWithMarkup,
                        'status' => 'in_stock',
                    ]);
                }
            }
        }

        $po->update([
            'status' => 'received',
            'received_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase Order successfully received'
        ]);
    }

    public function getItems(PurchaseOrder $po)
    {
        // Check if request wants inventory items
        $includeInventory = request()->boolean('inventory', false);

        $query = $po->items()->with('product');

        if ($includeInventory) {
            $query->with('inventoryItems');
        }

        $items = $query->get()->map(function ($item) use ($includeInventory) {
            $product = $item->product;

            $data = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $product->product_name ?? 'Unnamed Product',
                'quantity_ordered' => $item->quantity_ordered,
                'unit_price' => (float) $item->unit_price,
                // important: product-level boolean that the frontend will use
                'track_serials' => (bool) ($product->track_serials ?? false),
            ];

            if ($includeInventory) {
                $data['inventory_items'] = $item->inventoryItems->map(function ($inv) {
                    return [
                        'id' => $inv->id,
                        'serial_number' => $inv->serial_number ?? null,
                    ];
                })->toArray();
            }

            return $data;
        });

        return response()->json(['items' => $items]);
    }
}
