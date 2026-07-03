<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
public function register(): void
{
    // I-comment out muna para sa localhost isolation
    /*
    if (app()->environment('production')) {
        $this->app->bind('path.public', function() {
            return base_path('public');
        });
    }
    */
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
