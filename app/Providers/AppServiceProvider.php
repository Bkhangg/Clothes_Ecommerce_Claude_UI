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
        Gate::define('manage-products', fn(User $user) => $user->hasPermission('manage-products'));
        Gate::define('manage-categories', fn(User $user) => $user->hasPermission('manage-categories'));
        Gate::define('manage-employees', fn(User $user) => $user->hasPermission('manage-employees'));
        Gate::define('manage-brands', fn(User $user) => $user->hasPermission('manage-brands'));
        Gate::define('manage-orders', fn(User $user) => $user->hasPermission('manage-orders'));
    }
}
