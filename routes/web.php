<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\Sale;
use App\Http\Controllers\SaleDetailsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

    /* ----- Prefijos MERO EJEMPLO USAREMOS VOLT ----- */

    Route::prefix('category')->middleware('auth', 'Checkrole:admin')->group(function () {
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


    Route::prefix('user')->middleware('auth', 'Checkrole:admin')->group(function () {
        Volt::route('users/create', 'users.create')->name('users.create');
        Volt::route('users/index', 'users.index')->name('users.index');
        Volt::route('users/edit/{id}', 'users.edit')->name('users.edit');
    });

    Route::prefix('supplier')->middleware('auth', 'Checkrole:admin')->group(function () {
        Volt::route('suppliers/index', 'suppliers.index')->name('suppliers.index');
        Volt::route('suppliers/create', 'suppliers.create')->name('suppliers.create');
        Volt::route('suppliers/edit/{id}', 'suppliers.edit')->name('suppliers.edit');
    });

    Route::prefix('products')->middleware('auth', 'Checkrole:admin')->group(function () {
        Volt::route('products/index', 'products.index')->name('products.index');
        Volt::route('products/create', 'products.create')->name('products.create');
        Volt::route('products/edit/{id}', 'products.edit')->name('products.edit');
        Volt::route('products/show-image/{image_id}', 'products.show-image')->name('products.show-image');
    });

    Route::prefix('product_reports')->middleware('auth', 'Checkrole:admin')->group(function () {
        Volt::route('product_reports/index', 'product_reports.index')->name('product_reports.index');
        Volt::route('product_reports/index-slow', 'product_reports.index-slow')->name('product_reports.index-slow');
        Route::get('product_reports/pdf', [PdfController::class, 'productsStock'])->name('products.pdf');
        Route::get('product_reports/pdf-min', [PdfController::class, 'productsStockMin'])->name('products-min.pdf');
    });

    Route::prefix('purchases')->middleware('auth', 'Checkrole:admin')->group(function () {
        Volt::route('purchases/index', 'purchases.index')->name('purchases.index');
        Volt::route('purchases/create/{product_id}', 'purchases.create')->name('purchases.create');
        Volt::route('purchases/edit/{id}', 'purchases.edit')->name('purchases.edit');
    });

    Route::prefix('sales')->middleware('auth')->group(function () {
        Volt::route('sales/index', 'sales.index')->name('sales.index');
        Route::get('/ticket/{sale_id}', [PdfController::class, 'ticket'])->name('ticket.pdf');
    });

    Route::prefix('detail')->middleware('auth')->group(function () {
        Volt::route('sale_details/index', 'sale_details.index')->name('sale_details.index');
        Volt::route('sale_details/sale_detail/{sale_id}', 'sale_details.sale_detail')->name('sale_details.sale_detail');
    });

require __DIR__.'/auth.php';
