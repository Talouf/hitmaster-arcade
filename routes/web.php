<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SearchController;

// Autres routes existantes...

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/products', function () {
    return view('products');
});

Route::get('/contact', function () {
    return view('contact');
});
#News Route

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/search', [SearchController::class, 'search'])->name('search');