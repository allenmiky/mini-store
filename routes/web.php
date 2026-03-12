<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Yeh file mein saare web routes define hote hain
| Route = URL + Controller ka method
*/

// PUBLIC ROUTES - Koi bhi access kar sakta hai
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/products', [StoreController::class, 'products'])->name('products');
Route::get('/category/{slug}', [StoreController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [StoreController::class, 'product'])->name('product.show');

// CART ROUTES - Session based cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// CHECKOUT ROUTES - WITHOUT AUTH (Guest Checkout allowed)
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');           // checkout.index
    Route::post('/process', [CheckoutController::class, 'process'])->name('process'); // checkout.process
    Route::get('/success', [CheckoutController::class, 'success'])->name('success');   // checkout.success
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');
});

Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::put('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// & SIMPLE ROUTE (without prefix)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');   // checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');   // checkout

// ADMIN ROUTES  
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Category CRUD
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('/categories/{id}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle');
    
    // Product CRUD
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('/products/{id}/update-stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock'])->name('products.stock');
});

require __DIR__.'/auth.php'; // Authentication routes (login, register)
