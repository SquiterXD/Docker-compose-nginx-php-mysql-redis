<?php

use App\Http\Controllers\PM\WipLossQuantityController;
use App\Http\Controllers\PM\Api\WipLossQuantityApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('wip-loss-quantity')->name('wip-loss-quantity.')->group(function () {
        Route::post('lines', [WipLossQuantityApiController::class, 'getLines'])->name('lines');
        Route::put('store', [WipLossQuantityApiController::class, 'updateJobLines'])->name('store');
    });
});

Route::prefix('wip-loss-quantity')->name('wip-loss-quantity.')->group(function () {
    Route::get('/', [WipLossQuantityController::class, 'index'])->name('index');
});