<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Sale;
use App\Http\Controllers\SaleDetailsController;

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

    /* Prefijos MERO EJEMPLO USAREMOS VOLT*/
    Route::prefix('sales')->group(function () {
        Route::get('new_sale', [Sale::class, 'index'])->name('new_sale');
 
    });

    Route::prefix('detail')->group(function () {
        Route::get('detail_sale', [Sale::class, 'index'])->name('detail_sale');

    });
    
});

require __DIR__.'/auth.php';
