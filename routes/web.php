<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;

/*
|--------------------------------------------------------------------------
| Public / Auth routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes - only accessible to guests
Route::middleware(['guest:employee'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Protected: auth:employee
|--------------------------------------------------------------------------
| - Auto-registers ONLY safe GET navigation routes from config/menu.php
| - Manually declare CRUD POST/PUT/DELETE routes below (kept in role groups).
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:employee'])->group(function () {

    $menu = config('menu', []);

    foreach ($menu as $sectionKey => $section) {
        // Section index -> redirect to first visible GET subitem
        $visibleSubs = collect($section['subitems'] ?? [])->filter(function ($s) {
            $method = strtolower($s['method'] ?? 'get');
            return $method === 'get';
        })->values();

        $firstSub = $visibleSubs->first();

        if ($firstSub && isset($firstSub['uri'])) {
            $sectionRoles = $section['roles'] ?? ['*'];
            $middlewares = [];
            if (!in_array('*', $sectionRoles, true)) {
                $middlewares[] = 'role:' . implode(',', $sectionRoles);
            }

            // Register index redirect (only if not already registered)
            if (!Route::has($sectionKey)) {
                Route::get("/{$sectionKey}", function () use ($firstSub) {
                    return redirect(url($firstSub['uri']));
                })->name($sectionKey)
                  ->middleware($middlewares);
            }
        }

        // Register subitems
        foreach ($section['subitems'] as $sub) {
            $type   = $sub['type'] ?? 'view';
            $method = strtolower($sub['method'] ?? 'get');
            $uri    = trim($sub['uri'] ?? '', '/');
            $name   = $sub['name'] ?? Str::slug($sectionKey . '-' . ($sub['title'] ?? $uri));

            if ($uri === '' || $method !== 'get' || Route::has($name)) {
                continue;
            }

            $roles = $sub['roles'] ?? ['*'];
            $middlewares = [];
            if (!in_array('*', $roles, true)) {
                $middlewares[] = 'role:' . implode(',', $roles);
            }

            // ---- Route type handling ----
            if ($type === 'view') {
                $viewName = $sub['view'] ?? null;
                if (!$viewName) continue;

                Route::get($uri, function () use ($viewName) {
                    if (view()->exists($viewName)) {
                        return view($viewName);
                    }
                    abort(404);
                })->name($name)->middleware($middlewares);

            } elseif ($type === 'controller') {
                // Support controller => ClassName, method => 'index'
                $controller = $sub['controller'] ?? null;
                $methodName = $sub['method'] ?? 'index';

                if (!$controller || !class_exists($controller)) continue;

                Route::get($uri, [$controller, $methodName])
                    ->name($name)
                    ->middleware($middlewares);

            } else {
                // type == 'url' or unknown — no route registration
                continue;
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Manual CRUD routes (POST/PUT/DELETE)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:superadmin,admin'])->group(function () {

        // Employee Staff Management
        Route::get('/employee/staff-management', [EmployeeController::class, 'index'])
            ->name('employees.index');
        Route::post('/employee', [EmployeeController::class, 'store'])
            ->name('employees.store');
        

        // Supplier Management (store)
        Route::post('/settings/suppliers', [SupplierController::class, 'store'])
            ->name('suppliers.store');

        // Category Management (store)
        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        // Add Products
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('inventory/products', [ProductController::class, 'index'])
            ->name('inventory.products');

        Route::get('settings/suppliers', [SupplierController::class, 'index'])
            ->name('suppliers.index');

        Route::get('settings/categories', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/categories/{id}/subcategories', [CategoryController::class, 'getSubcategories']); 

        Route::post('/brands', [BrandController::class, 'store'])
            ->name('brands.store');

        // POS
        Route::get('dashboard/pos', [POSController::class, 'index'])
            ->name('pos.index');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/checkout', function() {
            return redirect()->route('pos.index');
        });
        Route::post('/pos/validate-serials', [POSController::class, 'validateSerials'])
            ->name('pos.validate-serials');
        Route::post('/pos/sales', [SaleController::class, 'store'])->name('pos.sales.store');
        Route::get('/pos/sales', [App\Http\Controllers\SaleController::class, 'index'])
            ->name('pos.sales.index');
        Route::get('sales/{sale}/json', [SaleController::class, 'showJson'])->name('sales.show.json');

        // Purchase Orders
        Route::get('/history/purchase-order', [PurchaseOrderController::class, 'index'])
            ->name('purchase-order.index');
        
        Route::get('inventory/stock-in', [PurchaseOrderController::class, 'create'])
            ->name('stock-in.index');
        Route::post('inventory/stock-in/store', [PurchaseOrderController::class, 'store'])
            ->name('purchase-orders.store');

        Route::get('/supplier/{id}/details', [SupplierController::class, 'details']);
        Route::post('/purchase-orders/{po}/receive', [PurchaseOrderController::class, 'receive'])
            ->name('purchase-orders.receive');
        Route::get('/purchase-orders/{po}/items', [PurchaseOrderController::class, 'getItems']);

        Route::get('/pos/inventory', [App\Http\Controllers\POSController::class, 'getInventory'])->name('pos.inventory');

        //customer
        Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
        Route::post('/customers/store/ajax', [CustomerController::class, 'storeAjax'])->name('customers.store.ajax');


    });

});
