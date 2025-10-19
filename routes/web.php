<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    // Generic section routes for other sidebar menus. These render blade views under
    // resources/views/pages/{section}/{page}.blade.php when present.
    $sections = ['dashboard','inventory', 'services', 'customer', 'employee', 'history', 'settings'];
    foreach ($sections as $section) {
        // index route for the section: /{section} -> first available page in that folder
        Route::get("/{$section}", function () use ($section) {
            $dir = resource_path('views/pages/' . $section);
            if (!\Illuminate\Support\Facades\File::isDirectory($dir)) abort(404);
            $files = \Illuminate\Support\Facades\File::files($dir);
            if (!count($files)) abort(404);
            // take first file in the directory
            $filename = pathinfo($files[0]->getFilename(), PATHINFO_FILENAME);
            // strip potential .blade or .php suffixes just in case
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
});


// SuperAdmin routes
Route::middleware(['auth:employee', 'superadmin'])->group(function () {
    // routes exclusive to SuperAdmin
});

// Admin/Manager routes
Route::middleware(['auth:employee', 'admin'])->group(function () {
    // routes exclusive to Admin/Manager
});

// Staff routes
Route::middleware(['auth:employee', 'staff'])->group(function () {
    // routes exclusive to Staff
});