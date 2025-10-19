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
    // dashboard index -> overview
    Route::get('/dashboard', function () {
        return view('pages.dashboard.overview');
    })->name('dashboard');

    // render dashboard subpages: /dashboard/{page}
    Route::get('/dashboard/{page}', function ($page) {
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $page)) abort(404);
        $view = "pages.dashboard.{$page}";
        if (view()->exists($view)) return view($view);
        abort(404);
    })->name('dashboard.page');
});