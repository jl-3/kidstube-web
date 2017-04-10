<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Laravel 5.4 introduced emoji support and uses utf8mb4 encoding, thus on old MySQL versions it needs
        // adjustment, as said here https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);

        // variable view_name can be used in any Blade view to retrieve its own name
        view()->composer('*', function ($view) {
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
