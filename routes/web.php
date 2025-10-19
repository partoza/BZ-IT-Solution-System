<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect('/dashboard');
})->name('login.submit');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

