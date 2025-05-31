<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/* MERO EJEPLO USAREMOS VOLT */

use App\Http\Controllers\Sale;
use App\Http\Controllers\SaleDetailsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;

/* MERO EJEPLO USAREMOS VOLT */

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Volt::route('categories/index', 'categories.index')->name('categories.index');

    Volt::route('customers/index', 'customers.index')->name('customers.index');

    Volt::route('products/index', 'products.index')->name('products.index');

    Volt::route('sales/index', 'sales.index')->name('sales.index');

    Volt::route('sale_details/index', 'sale_details.index')->name('sale_details.index');

    Volt::route('users/index', 'users.index')->name('users.index');

    /* ----- Prefijos MERO EJEMPLO USAREMOS VOLT ----- */

    Route::prefix('sales')->group(function () {
        Route::get('new_sale', [Sale::class, 'index'])->name('new_sale');
 
    });

    Route::prefix('detail')->group(function () {
        Route::get('detail_sale', [Sale::class, 'index'])->name('detail_sale');

    });

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories');

    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products');
    });

    Route::prefix('costumers')->group(function () {
        Route::get('/', [CostumersController::class, 'index'])->name('costumers');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [CostumersController::class, 'index'])->name('users');
    });

    /* ----- Prefijos MERO EJEMPLO USAREMOS VOLT ----- */
    
});

require __DIR__.'/auth.php';
