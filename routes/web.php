<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminDashboardController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::resource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/search', [SearchController::class, 'search'])->name('search');

// User dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/news/create', [AdminController::class, 'createNews'])->name('admin.news.create');
        Route::post('/news', [AdminController::class, 'storeNews'])->name('admin.news.store');
        Route::delete('/news/{id}', [AdminController::class, 'deleteNews'])->name('admin.news.delete');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
        Route::get('/news/{id}/edit', [AdminController::class, 'editNews'])->name('admin.news.edit');
        Route::put('/news/{id}', [AdminController::class, 'updateNews'])->name('admin.news.update');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
        Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    });
});

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [PaymentController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

// Cart and checkout routes
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/error', [CheckoutController::class, 'error'])->name('checkout.error');
Route::post('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::get('/checkout/failed', function () {
    return view('checkout.failed');
})->name('checkout.failed');

Route::get('/profile/add-shipping-info', [ProfileController::class, 'addShippingInfo'])->name('profile.add-shipping-info');
Route::post('/profile/store-shipping-info', [ProfileController::class, 'storeShippingInfo'])->name('profile.store-shipping-info');

Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

// API routes
Route::get('/api/products', [ProductController::class, 'apiIndex']);
Route::post('/api/reviews', [ReviewController::class, 'apiStore'])->middleware('auth:api');

require __DIR__ . '/auth.php';