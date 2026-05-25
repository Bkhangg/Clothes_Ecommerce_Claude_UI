<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-products', function (User $user) {
            return $user->role === 'admin' || ($user->role === 'employee' && $user->is_active);
        });

        Gate::define('manage-categories', function (User $user) {
            return $user->role === 'admin' || ($user->role === 'employee' && $user->is_active);
        });

        Gate::define('manage-employees', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-orders', function (User $user) {
            return $user->role === 'admin' || ($user->role === 'employee' && $user->is_active);
        });
    }
}
