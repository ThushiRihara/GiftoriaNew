<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use App\Livewire\ProductList;
use App\Livewire\Cart;
use App\Livewire\CheckoutForm;
use App\Livewire\PaymentForm;
use App\Livewire\OrderSuccess;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/admin/login', function () {
return view('admin.login');
})->name('admin.login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Manage AddOns page
Route::get('/admin/addons/manage', function () {
    return view('admin.addons.manage');
})->name('admin.addons.manage');

Route::prefix('admin')->middleware('web')->group(function () {
    Route::get('/gifts/manage', function () {
        return view('admin.gifts.manage');
    })->name('admin.gifts.manage');
});

Route::get('/admin/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])
    ->name('admin.customers.manage')
    ->middleware('auth:admin'); // ensure this matches your admin guard


// Guest routes
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/products', function() {
    return view('products');  // Product List Blade wrapper
})->name('products');
Route::get('/products/{id}', function($id) {
    return view('product-detail', ['gift' => App\Models\Gift::findOrFail($id)]);  // Product Details
})->name('products.show');

// Authenticated customer routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cart', function() {
        return view('cart');  // Cart Blade wrapper
    })->name('cart');

    Route::get('/checkout', function() {
        return view('checkout');  // Checkout Blade wrapper
    })->name('checkout');

    Route::get('/payment', function() {
        return view('payment');  // Payment Blade wrapper
    })->name('payment');

    Route::get('/order-success', function() {
        return view('order-success');  // Order success page
    })->name('order.success');
});
    
Route::get('/admin/offers/manage', function() {
    return view('admin.offers.manage');
})->name('admin.offers.manage');

Route::prefix('admin')->group(function () {
    Route::get('/offers/manage', [App\Http\Controllers\Admin\OfferController::class, 'index'])
        ->name('admin.offers.manage');
});

