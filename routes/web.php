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
    Route::get('/overview', function () {
        return view('pages.overview');
    })->name('overview');
});

// Dynamic route to render pages located under resources/views/pages/{section}/{page}.blade.php
Route::get('/{section}/{page}', function ($section, $page) {
    // sanitize inputs: allow only alpha, dash and underscore
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $section) || !preg_match('/^[a-zA-Z0-9_-]+$/', $page)) {
        abort(404);
    }

    $view = "pages.{$section}.{$page}";
    if (view()->exists($view)) {
        return view($view);
    }

    abort(404);
})->name('pages.render');

