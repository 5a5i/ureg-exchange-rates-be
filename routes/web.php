<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('app');
})->name('login');

Route::get('/register', function () {
    return view('app');
})->name('register');

// Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
