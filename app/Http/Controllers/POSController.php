<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryItem;
use Illuminate\Http\Request;


class POSController extends Controller
{
    public function index()
    {
        $branchId = auth()->user()->branch_id; // current user's branch

        $categories = Category::whereNull('parent_id')
            ->where('category_type', 'product')
            ->where('status', 'Active')
            ->with(['products' => function($q) use ($branchId) {
                $q->whereHas('inventoryItems', function($iq) use ($branchId) {
                    $iq->where('branch_id', $branchId)
                    ->where('status', 'in_stock');
                })->with(['inventoryItems' => function($iq) use ($branchId) {
                    $iq->where('branch_id', $branchId)
                    ->where('status', 'in_stock');
                }]);
            }, 'children.subProducts' => function($q) use ($branchId) {
                $q->whereHas('inventoryItems', function($iq) use ($branchId) {
                    $iq->where('branch_id', $branchId)
                    ->where('status', 'in_stock');
                })->with(['inventoryItems' => function($iq) use ($branchId) {
                    $iq->where('branch_id', $branchId)
                    ->where('status', 'in_stock');
                }]);
            }])->get();

        $products = Product::where('active_status', true)
            ->whereHas('inventoryItems', function($iq) use ($branchId) {
                $iq->where('branch_id', $branchId)
                ->where('status', 'in_stock');
            })
            ->with(['inventoryItems' => function($iq) use ($branchId) {
                $iq->where('branch_id', $branchId)
                ->where('status', 'in_stock');
            }])
            ->get();

        // Add brands
        $brands = Brand::with(['products' => function($q) use ($branchId) {
            $q->whereHas('inventoryItems', function($iq) use ($branchId) {
                $iq->where('branch_id', $branchId)
                ->where('status', 'in_stock');
            });
        }])->get();

        return view('pages.dashboard.point-of-sales', compact('categories', 'products', 'brands'));
    }

    public function filter(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        $q     = $request->q;
        $brand = $request->brand;
        $disc  = $request->disc;

        $query = Product::where('active_status', true)
            ->whereHas('inventoryItems', function($iq) use ($branchId) {
                $iq->where('branch_id', $branchId)
                   ->where('status', 'in_stock');
            })
            ->with(['inventoryItems' => function($iq) use ($branchId) {
                $iq->where('branch_id', $branchId)
                   ->where('status', 'in_stock');
            }]);

        if ($q)     $query->where('product_name', 'like', "{$q}%");
        if ($brand) $query->where('brand_id', $brand);
        if ($disc)  $query->whereColumn('discounted_price', '<', 'base_price');

        $products = $query->get();

        return view('pages.dashboard.partials.product-cards-grid', compact('products'))->render();
    }
}