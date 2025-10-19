<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect('/overview');
})->name('login.submit');

Route::get('/overview', function () {
    return view('pages.dashboard.overview');
})->name('overview');

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

