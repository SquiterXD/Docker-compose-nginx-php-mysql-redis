<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OM\PrepareSaleOrder\Search\PrepareSaleOrdersController;
use App\Http\Controllers\OM\PrepareSaleOrder\Search\Ajax\PrepareSaleOrdersController as AjaxPrepareSaleOrdersController;

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

// MCR -- OM Search Sale Orders
Route::prefix('prepare-sale-orders')->name('prepare-sale-orders.')->group(function () {
    // -- domestic/export
    Route::get('search', [PrepareSaleOrdersController::class, 'index'])->name('search');

    // Ajax
    Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
        Route::get('get-so-lists', [AjaxPrepareSaleOrdersController::class, 'getSoLists'])->name('get-so-lists');
        Route::get('get-prepare-so-lists', [AjaxPrepareSaleOrdersController::class, 'getPrepareSoLists'])->name('get-prepare-so-lists');
        Route::get('get-period-lists', [AjaxPrepareSaleOrdersController::class, 'getPeriodLists'])->name('get-period-lists');
        Route::get('get-pi-lists', [AjaxPrepareSaleOrdersController::class, 'getPiLists'])->name('get-pi-lists');
        Route::get('get-invoice-lists', [AjaxPrepareSaleOrdersController::class, 'getInvoiceLists'])->name('get-invoice-lists');
        Route::get('get-customer-lists', [AjaxPrepareSaleOrdersController::class, 'getCustomerLists'])->name('get-customer-lists');
        Route::get('get-order-type-lists', [AjaxPrepareSaleOrdersController::class, 'getOrderTypeLists'])->name('get-order-type-lists');
    });
});
