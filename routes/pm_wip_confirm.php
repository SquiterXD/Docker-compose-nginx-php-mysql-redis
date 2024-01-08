<?php

use App\Http\Controllers\PM\WipConfirmController;
use App\Http\Controllers\PM\Api\WipConfirmApiController;
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
    Route::prefix('wip-confirm')->name('wip-confirm.')->group(function () {
        Route::post('/importMesData', [WipConfirmApiController::class, 'importMesData'])->name('importMesData');
        Route::post('lines', [WipConfirmApiController::class, 'showJobLines'])->name('lines');
        Route::put('store', [WipConfirmApiController::class, 'updateJobLines'])->name('store');

        Route::put('daily-store', [WipConfirmApiController::class, 'dailyStore'])->name('daily-store');
        Route::put('daily-delete', [WipConfirmApiController::class, 'dailyDelete'])->name('daily-delete');
        Route::get('daily-lines', [WipConfirmApiController::class, 'dailyLines'])->name('daily-lines');
    });
});


Route::prefix('wip-confirm')->name('wip-confirm.')->group(function () {
    Route::get('/', [WipConfirmController::class, 'index'])->name('index');
    Route::get('/search', [WipConfirmController::class, 'search'])->name('search');
    Route::get('/jobs', [WipConfirmController::class, 'showJob'])->name('jobs');
    Route::get('/export-pdf-parameters/{report_code}', [WipConfirmController::class, 'exportPdfParameters'])->name('export-pdf-parameters');
    Route::post('/export-pdf', [WipConfirmController::class, 'exportPdf'])->name('export-pdf');
    Route::get('/get-export-pdf', [WipConfirmController::class, 'getExportPdf'])->name('get-export-pdf');

    Route::get('/daily', [WipConfirmController::class, 'daily'])->name('daily');
});




// Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
//     Route::prefix('wip-loss-quantity')->name('wip-loss-quantity.')->group(function () {
//         Route::post('lines', [WipConfirmApiController::class, 'getLines'])->name('lines');
//     });
// });

// Route::prefix('wip-loss-quantity')->name('wip-loss-quantity.')->group(function () {
//     Route::get('/', [WipConfirmController::class, 'lossQty'])->name('index');
// });