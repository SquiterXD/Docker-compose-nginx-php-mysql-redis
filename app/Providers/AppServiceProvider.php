<?php

namespace App\Providers;

use App\Http\Controllers\IR\Ajax\Services\CarsService;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\CarsServiceInterface;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockServiceInterface;
use App\Http\Controllers\IR\Ajax\Services\StockService;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockServiceInterface::class, StockService::class);
        $this->app->bind(CarsServiceInterface::class, CarsService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
