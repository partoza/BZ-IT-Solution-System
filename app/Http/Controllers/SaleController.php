<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SaleService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\InventoryItem;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function store(Request $request)
    {
        $request->merge([
            'branch_id' => auth()->user()->branch_id ?? null,
            'employee_id' => auth()->user()->employee_id ?? null,
        ]);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,branch_id',
            'employee_id' => 'required|exists:employees,employee_id',
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cash,gcash',
            'amount_paid' => 'required|numeric|min:0',
            'payment_reference' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,reserved,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.line_discount' => 'nullable|numeric|min:0',
            'items.*.serial_numbers' => 'nullable|array',
        ], [
            // Branch / Employee
            'branch_id.required' => 'Unable to detect your branch. Please refresh the page.',
            'branch_id.exists' => 'Your branch is invalid. Please contact support.',
            'employee_id.required' => 'Unable to detect your employee account.',
            'employee_id.exists' => 'Your employee account is invalid. Please contact support.',

            // Customer
            'customer_id.required' => 'Please select or enter a customer.',
            'customer_id.exists' => 'The selected customer does not exist.',

            // Payment
            'payment_method.required' => 'Please choose a payment method.',
            'payment_method.in' => 'The selected payment method is not supported.',
            'amount_paid.required' => 'Please enter the amount paid.',
            'amount_paid.numeric' => 'Amount paid must be a number.',
            'amount_paid.min' => 'Amount paid cannot be less than 0.',

            'payment_reference.max' => 'Payment reference is too long.',

            // Status
            'status.in' => 'Sale status is invalid.',

            // Items
            'items.required' => 'Please add at least one product to the sale.',
            'items.array' => 'Invalid items format.',
            'items.min' => 'Please add at least one product to the sale.',
            'items.*.product_id.required' => 'Each item must have a product selected.',
            'items.*.product_id.exists' => 'One of the selected products does not exist.',
            'items.*.quantity.required' => 'Please specify the quantity for each product.',
            'items.*.quantity.integer' => 'Quantity must be a whole number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.line_discount.numeric' => 'Discount must be a number.',
            'items.*.line_discount.min' => 'Discount cannot be negative.',
            'items.*.serial_numbers.array' => 'Serial numbers must be provided as a list.',
        ]);

        $missingSerialProducts = [];
        $validatedItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $requiresSerial = $product ? ($product->track_serials ?? false) : false;

            if ($requiresSerial) {
                $serials = array_filter($item['serial_numbers'] ?? [], 'strlen');
                $serialCount = count($serials);

                if ($serialCount !== intval($item['quantity'])) {
                    $missingSerialProducts[] = $product->product_name ?? $product->name ?? "Product ID {$item['product_id']}";
                    continue;
                }

                $serialPrices = InventoryItem::whereIn('serial_number', $serials)
                    ->where('product_id', $item['product_id'])
                    ->where('status', 'in_stock')
                    ->pluck('unit_price')
                    ->toArray();

                if (count($serialPrices) !== $serialCount) {
                    $missingSerialProducts[] = $product->product_name ?? $product->name ?? "Product ID {$item['product_id']}";
                    continue;
                }

                $item['unit_price'] = array_sum($serialPrices) / count($serialPrices);
            } else {
                // Non-serialized — fetch unit_price from inventory
                $inventoryItem = InventoryItem::where('product_id', $item['product_id'])
                    ->where('branch_id', auth()->user()->branch_id)
                    ->where('status', 'in_stock')
                    ->first();

                if (!$inventoryItem) {
                    return response()->json([
                        'success' => false,
                        'message' => "No available inventory for product: " . ($product->product_name ?? $product->name),
                    ], 422);
                }

                $item['unit_price'] = $inventoryItem->unit_price;
            }

            $validatedItems[] = $item;
        }

        if (!empty($missingSerialProducts)) {
            return response()->json([
                'success' => false,
                'message' => 'Serial numbers are missing or invalid for: ' . implode(', ', $missingSerialProducts),
            ], 422);
        }

        // ✅ Now compute total based on actual (validated or fetched) prices
        $total = collect($validatedItems)->sum(function ($item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $discount = $item['line_discount'] ?? 0;
            return $lineTotal - $discount;
        });

        if ($validated['amount_paid'] < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Amount paid must be greater than or equal to total amount',
            ], 422);
        }

        // Pass modified items to the service
        $validated['items'] = $validatedItems;
        $result = $this->saleService->store($validated);

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json(['success' => false, 'message' => $result['error'] ?? 'Unknown error'], 500);
    }

    public function index(Request $request)
    {
        $branchId = auth()->guard('employee')->user()?->branch_id;
        $perPage = intval($request->query('per_page', 10));

        // Filters
        $search = $request->query('search');
        $status = $request->query('status');
        $paymentMethod = $request->query('payment_method');

        // Base query with relationships
        $query = \App\Models\Sale::with(['customer', 'items.product', 'items.inventoryItems', 'createdBy', 'employee'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId));

        // 🔍 Search filter (sales_number, customer, product, employee, serial number)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sales_number', 'like', "%{$search}%")
                ->orWhereHas('customer', fn($c) => 
                    $c->where('name', 'like', "%{$search}%")
                )
                ->orWhereHas('items.product', fn($p) => 
                    $p->where('product_name', 'like', "%{$search}%")
                )
                ->orWhereHas('items.inventoryItems', fn($inv) =>
                    $inv->where('serial_number', 'like', "%{$search}%")
                )
                ->orWhereHas('employee', fn($e) => 
                    $e->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                );
            });
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by payment method
        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        // Pagination
        $sales = $query->orderBy('sold_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Summary metrics
        $totalSales = \App\Models\Sale::count();
        $completedSales = \App\Models\Sale::where('status', 'completed')->count();
        $reservedSales = \App\Models\Sale::where('status', 'reserved')->count();
        $cancelledSales = \App\Models\Sale::where('status', 'cancelled')->count();

        // Total value of all sales
        $totalSalesValue = \DB::table('sale_items')
            ->selectRaw('SUM(line_total) as total')
            ->value('total');

        // Sales completed this month
        $salesThisMonth = \DB::table('sales')
            ->where('status', 'completed')
            ->whereMonth('sold_at', now()->month)
            ->whereYear('sold_at', now()->year)
            ->selectRaw('SUM(grand_total) as total')
            ->value('total');

        // Pending or reserved value
        $reservedValue = \DB::table('sales')
            ->where('status', 'reserved')
            ->selectRaw('SUM(grand_total) as total')
            ->value('total');

        // Cancelled value
        $cancelledValue = \DB::table('sales')
            ->where('status', 'cancelled')
            ->selectRaw('SUM(grand_total) as total')
            ->value('total');

        // Top customer by total purchases
        $topCustomer = \App\Models\Customer::with(['sales'])
            ->get()
            ->map(function ($customer) {
                $total = $customer->sales->sum('grand_total');
                $customer->total_spent = $total;
                return $customer;
            })
            ->sortByDesc('total_spent')
            ->first();

        return view('pages.history.transaction-history', compact(
            'sales',
            'search',
            'status',
            'paymentMethod',
            'perPage',
            'totalSales',
            'completedSales',
            'reservedSales',
            'cancelledSales',
            'totalSalesValue',
            'salesThisMonth',
            'reservedValue',
            'cancelledValue',
            'topCustomer'
        ));
    }

    public function showJson(\App\Models\Sale $sale): \Illuminate\Http\JsonResponse
    {
        // Load relations used by the response
        $sale->load(['customer', 'employee', 'items.product', 'items.inventoryItems']);

        $items = [];
        foreach ($sale->items as $index => $item) {
            $quantity = (int) ($item->quantity ?? 0);

            // Try to use stored unit_price from the sale_item record first
            $unitPrice = (float) ($item->unit_price ?? $item->unitPrice ?? 0);

            // If unit price missing, follow store() logic to fetch/derive it
            if ($unitPrice <= 0) {
                $product = $item->product;
                $requiresSerial = $product ? ($product->track_serials ?? false) : false;

                if ($requiresSerial) {
                    // Attempt to derive from linked inventory items (serials)
                    $serials = $item->inventoryItems->pluck('serial_number')->filter()->values()->all();

                    if (!empty($serials)) {
                        $serialPrices = \App\Models\InventoryItem::whereIn('serial_number', $serials)
                            ->where('product_id', $item->product_id)
                            ->pluck('unit_price')
                            ->toArray();

                        if (!empty($serialPrices)) {
                            $unitPrice = array_sum($serialPrices) / count($serialPrices);
                        }
                    }
                } else {
                    // Non-serialized: try to fetch any in-stock inventory unit_price for the branch
                    $inventoryItem = \App\Models\InventoryItem::where('product_id', $item->product_id)
                        ->when($sale->branch_id, fn($q) => $q->where('branch_id', $sale->branch_id))
                        ->where('status', 'in_stock')
                        ->first();

                    if ($inventoryItem) {
                        $unitPrice = $inventoryItem->unit_price;
                    }
                }
            }

            $lineDiscount = (float) ($item->line_discount ?? 0);
            $lineTotal = round(($quantity * $unitPrice) - $lineDiscount, 2);

            $serials = $item->inventoryItems->pluck('serial_number')->filter()->values()->all();

            $items[] = [
                'line' => $index + 1,
                'product_id' => $item->product->product_id ?? $item->product_id ?? null,
                'product_name' => $item->product->product_name ?? $item->product->name ?? 'Unknown',
                'qty' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'line_discount' => round($lineDiscount, 2),
                'line_total' => $lineTotal,
                'serials' => $serials,
            ];
        }

        // Subtotal: sum of line totals before sale-level discount/vat
        $subtotal = array_sum(array_map(fn($i) => ($i['qty'] * $i['unit_price']), $items));

        // Sale-level discount / VAT logic: prefer stored values if present
        $saleDiscount = (float) ($sale->discount ?? 0);
        $vat = null;
        if (isset($sale->vat)) {
            $vat = (float) $sale->vat;
        } else {
            // default VAT rate 12% on (subtotal - saleDiscount)
            $vat = round(($subtotal - $saleDiscount) * 0.12, 2);
        }

        $grandTotal = (float) ($sale->grand_total ?? round($subtotal - $saleDiscount + $vat, 2));
        $amountPaid = (float) ($sale->amount_paid ?? 0);
        $change = $amountPaid > $grandTotal ? round($amountPaid - $grandTotal, 2) : 0.00;

        $payload = [
            'id' => $sale->id,
            'sales_number' => $sale->sales_number,
            'sold_at' => optional($sale->sold_at)->toDateTimeString(),
            'cashier' => $sale->employee?->full_name ?? $sale->createdBy?->full_name ?? null,
            'customer' => $sale->customer?->name ?? 'Walk-in',
            'payment_method' => $sale->payment_method ?? 'cash',
            'amount_paid' => round($amountPaid, 2),
            'change' => $change,
            'subtotal' => round($subtotal, 2),
            'vat' => round($vat, 2),
            'discount' => round($saleDiscount, 2),
            'grand_total' => round($grandTotal, 2),
            'items' => $items,
        ];

        return response()->json(['success' => true, 'sale' => $payload]);
    }
}