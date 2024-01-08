<?php
// Utility

use App\Http\Controllers\OM\Api\OrderEcomController;
use App\Http\Controllers\OM\GenerateFile\GenerateFileContrller;
use Illuminate\Support\Facades\Route;

// Api
use App\Http\Controllers\PM\Api\AdditiveInventoryAlertController;
use App\Http\Controllers\PM\Api\RawMaterialInventoryAlertController;
use App\Http\Controllers\PM\Api\RawMaterialReportController as ApiRawMaterialReportController;
use App\Http\Controllers\PM\Api\RawMaterialListController as ApiRawMaterialListController;
use App\Http\Controllers\PM\Settings\MachineRelationController;
use App\Http\Controllers\PM\Ajax\ConfirmLossOrderController as AjaxConfirmLossOrderController;
// Web
use App\Http\Controllers\PM\Web\RawMaterialListController;
use App\Http\Controllers\PM\Web\RawMaterialReportController;
use App\Http\Controllers\PM\Web\AdditiveInventoryAlertController as AdditiveInventoryAlertWeb;
use App\Http\Controllers\PM\Web\RawMaterialInventoryAlertController as RawMaterialInventoryAlertWeb;


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
Route::view('pdr1120', '/ct/reports/pdr1120/index');
Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('confirm-order')->group(function() {
        Route::post('/ajax/fetch-lov-new', [AjaxConfirmLossOrderController::class, 'fetchLovNew'])->name('confirm-order.fetch-lov-new');
    });
    Route::prefix('additive-inventory-alert')->name('additive-inventory-alert.')->group(function () {
        Route::post('/', [AdditiveInventoryAlertController::class, 'index'])->name('index');
        Route::post('/store', [AdditiveInventoryAlertController::class, 'store'])->name('store');
        Route::post('/get-type-order', [AdditiveInventoryAlertController::class, 'getTypeOrder'])->name('getTypeOrder');
        Route::post('/save-report-number', [AdditiveInventoryAlertController::class, 'saveReportNumber'])->name('saveReportNumber');
        Route::post('/product-lists', [AdditiveInventoryAlertController::class, 'productLists'])->name('productLists');
    });

    Route::get('recalculator-remaining-amount/{customer_id}', [OrderEcomController::class, 'reCalculateRemainingAmount']);
    Route::get('recalculator-remaining-amount-order/{prepare_order_number}', [OrderEcomController::class, 'reCalculateRemainingAmountOrder']);

    Route::prefix('raw-material-inventory-alert')->name('raw-material-inventory-alert.')->group(function () {
        Route::post('/', [RawMaterialInventoryAlertController::class, 'index'])->name('index');
        Route::post('/store', [RawMaterialInventoryAlertController::class, 'store'])->name('store');
        Route::post('/product-lists', [RawMaterialInventoryAlertController::class, 'productLists'])->name('productLists');
    });
    Route::prefix('raw_material_report')->name('raw_material_report.')->group(function () {
        Route::post('/', [ApiRawMaterialReportController::class, 'index'])->name('index');
        Route::post('/update-flag', [ApiRawMaterialReportController::class, 'updateFlag'])->name('update-flag');
        // raw_material_remove_image
    });
    Route::prefix('raw_material_list')->name('raw_material_list.')->group(function () {
        Route::post('/get-cate', [ApiRawMaterialListController::class, 'index'])->name('index');
        Route::any('/find', [ApiRawMaterialListController::class, 'find'])->name('find');
        Route::post('/image-upload', [ApiRawMaterialListController::class, 'imageUpload'])->name('image-upload');
        Route::post('/image-remove', [ApiRawMaterialListController::class, 'imageRemove'])->name('image-remove');
        Route::post('/store', [ApiRawMaterialListController::class, 'store'])->name('store');
        // raw_material_remove_image
    });
});

Route::group(['prefix' => 'generate-file-text'], function() {
    Route::get('/', [GenerateFileContrller::class, 'index']);
    Route::post('/', [GenerateFileContrller::class, 'genFile']);
});

foreach (['0039', 'additive_inventory_alert'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [AdditiveInventoryAlertWeb::class, 'index'])->name("index");
    });
}

foreach (['0040', 'raw_material_inventory_alert'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [RawMaterialInventoryAlertWeb::class, 'index'])->name("index");
    });
}

foreach (['raw_material_list'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [RawMaterialListController::class, 'index'])->name("index");
        Route::get('/request-raw-material', [RawMaterialListController::class, 'requestRaMaterial'])->name("request-raw-material");
        Route::get('/inform-raw-material', [RawMaterialListController::class, 'informRaMaterial'])->name("inform-raw-material");
    });
}

foreach (['raw_material_report'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [RawMaterialReportController::class, 'index'])->name("index");

    });
}


Route::group(['prefix'=>'settings/machine-relation'], function() {
    Route::post('/api/fetch/machine-group', [MachineRelationController::class, 'fetchMachineGroup']);
    Route::post('/api/fetch/line-mf', [MachineRelationController::class, 'fetchLineMf']);
    Route::post('/api/fetch/work', [MachineRelationController::class, 'fetchWork']);
    Route::post('/api/fetch/machine', [MachineRelationController::class, 'fetchMachine']);
});

// foreach (['0021', 'raw_material_inventory_alert'] as $routeBase) {
//     Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
//         Route::get('/', [RawMaterialListController::class, 'index'])->name("index");
//     });
// }
