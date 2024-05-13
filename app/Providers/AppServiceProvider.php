<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerUserPolicies();
    }

    /**
     * Register the user-related policies.
     *
     * @return void
     */
    public function registerUserPolicies()
    {
        Gate::define('view-button', function ($user) {
            return $user->hasRole(2);
        });
        Gate::define('view-users-table', function ($user) {
            return $user->hasRole(2) || $user->hasRole(1);
        });

        Gate::define('view-employees-table', function ($user) {
            return $user->hasRole(2) || $user->hasRole(1);
        });
    }
}
