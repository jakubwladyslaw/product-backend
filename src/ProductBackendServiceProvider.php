<?php

namespace Jakub\ProductBackend;

use Illuminate\Support\ServiceProvider;

class ProductBackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Jakub\ProductBackend\Http\Controllers\ProductController');
    }
}
