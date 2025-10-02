<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
//use App\Http\Controllers\Admin\AddOnController;


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

