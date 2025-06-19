<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* Para permisos solo para las vistas de los menus. */
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
        Gate::define('all-users', function (User $user) {
            return in_array($user->role, ['admin', 'cashier']);
        });
    }
}
