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
});

    /* ----- Prefijos MERO EJEMPLO USAREMOS VOLT ----- */

    Route::prefix('category')->middleware('auth')->group(function () {
        /*
        Route::get('/', [CategoriesController::class, 'index'])->name('categories');
        Route::get('create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/show/{id}', [CategoriesController::class, 'show'])->name('categories.show'); 
        Route::delete('/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        */
        
        Volt::route('categories/index', 'categories.index')->name('categories.index');
        Volt::route('categories/create', 'categories.create')->name('categories.create');
        Volt::route('categories/edit/{id}', 'categories.edit')->name('categories.edit');
    });


    Route::prefix('user')->middleware('auth')->group(function () {
        Volt::route('users/create', 'users.create')->name('users.create');
        Volt::route('users/index', 'users.index')->name('users.index');
        Volt::route('users/edit/{id}', 'users.edit')->name('users.edit');
    });

    Route::prefix('supplier')->middleware('auth')->group(function () {
        Volt::route('suppliers/index', 'suppliers.index')->name('suppliers.index');
        Volt::route('suppliers/create', 'suppliers.create')->name('suppliers.create');
        Volt::route('suppliers/edit/{id}', 'suppliers.edit')->name('suppliers.edit');
    });

    Route::prefix('products')->middleware('auth')->group(function () {
        Volt::route('products/index', 'products.index')->name('products.index');
        Volt::route('products/create', 'products.create')->name('products.create');
        Volt::route('products/edit/{id}', 'products.edit')->name('products.edit');
    });

    Route::prefix('sales')->middleware('auth')->group(function () {
        Volt::route('sales/index', 'sales.index')->name('sales.index');
        Volt::route('sales/create', 'sales.create')->name('sales.create');
        Volt::route('sales/edit/{id}', 'sales.edit')->name('sales.edit');
    });

    Route::prefix('detail')->middleware('auth')->group(function () {
        Volt::route('sale_details/index', 'sale_details.index')->name('sale_details.index');
        Volt::route('sale_details/create', 'sale_details.create')->name('sale_details.create');
        Volt::route('sale_details/edit/{id}', 'sale_details.edit')->name('sale_details.edit');
    });

require __DIR__.'/auth.php';
