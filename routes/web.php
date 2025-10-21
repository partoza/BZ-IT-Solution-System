<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;

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

// Protected Routes
Route::middleware(['auth:employee'])->group(function () {
    // Dedicated route for Add Product page (inventory/addproduct)
    // Put this before the generic section routes so it doesn't get shadowed by /{section}/{page}
    Route::get('/inventory/addproduct', function () {
        return view('nonmenu.inventory.addproduct');
    })->name('products.add');

    // Generic section routes for other sidebar menus. These render blade views under
    // resources/views/pages/{section}/{page}.blade.php when present.
    $sections = ['dashboard', 'services', 'customer', 'history'];
    foreach ($sections as $section) {
        // index route for the section: /{section}
        Route::get("/{$section}", function () use ($section) {
            $dir = resource_path('views/pages/' . $section);
            if (!\Illuminate\Support\Facades\File::isDirectory($dir)) abort(404);
            $files = \Illuminate\Support\Facades\File::files($dir);
            if (!count($files)) abort(404);
            $filename = pathinfo($files[0]->getFilename(), PATHINFO_FILENAME);
            $slug = preg_replace('/(\.blade|\.php)$/', '', $filename);
            $view = "pages.{$section}.{$slug}";
            if (view()->exists($view)) return view($view);
            abort(404);
        })->name($section);

        // render section subpages: /{section}/{page}
        Route::get("/{$section}/{page}", function ($page) use ($section) {
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $page)) abort(404);
            $view = "pages.{$section}.{$page}";
            if (view()->exists($view)) return view($view);
            abort(404);
        })->name("{$section}.page");
    }


    // Employee Staff Management route (only superadmin & admin)
    Route::middleware(['role:superadmin,admin'])->group(function () {
        
        // Employee Staff Management Routes
        Route::get('/employee/staff-management', [EmployeeController::class, 'index'])
            ->name('employee.staff-management');
        Route::post('/employee', [EmployeeController::class, 'store'])
            ->name('employees.store');

        // Supplier Management Routes
        Route::get('/settings/suppliers', [SupplierController::class, 'index'])
            ->name('suppliers.index');
        Route::post('/settings/suppliers', [SupplierController::class, 'store'])
            ->name('suppliers.store');

        // Category Management Routes
        Route::get('/inventory/categories', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');
            
    });
});
