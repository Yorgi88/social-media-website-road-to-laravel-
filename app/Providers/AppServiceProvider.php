<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('visitAdminPages', function($user){
            if ( $user->isAdmin === 1) {
                # code...
                return true;
            }
            return '<h2>Only for admins</h2>';
            
        });
    }
}
