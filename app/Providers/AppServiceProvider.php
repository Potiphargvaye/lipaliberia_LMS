<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }



        // Student Portal
        Gate::define('is-student', function (User $user) {
            return $user->hasRole('Student');
        });

        // Shared Admin Dashboard (all staff)
        Gate::define('is-admin', function (User $user) {
            return $user->hasAnyRole([
                'Super Admin',
                'Administrator',
                'Teacher',
                'Facilitator',
                'HR',
                'Finance',
                'Registrar',
            ]);
        });
    }
}
