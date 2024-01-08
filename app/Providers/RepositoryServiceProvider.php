<?php

namespace App\Providers;

use App\Http\Controllers\IR\Ajax\Repositories\CarsRepository;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockHeadersRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockLinesRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\StockHeaderRepository;
use App\Http\Controllers\IR\Ajax\Repositories\StockLinesRepository;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockHeadersRepositoryInterface::class, StockHeaderRepository::class);
        $this->app->bind(StockLinesRepositoryInterface::class, StockLinesRepository::class);
        $this->app->bind(CarsRepositoryInterface::class, CarsRepository::class);
    }

    /**
     * Bootstrap anyapplication services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
