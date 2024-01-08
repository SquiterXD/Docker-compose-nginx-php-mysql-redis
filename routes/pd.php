<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PD\Setting\ProgramColumnController;
// use App\Http\Controllers\PD\Setting\SettingLookupController;
use App\Http\Controllers\PD\Setting\SimuRawMaterialController;
use App\Http\Controllers\PD\ExpFormulaController;
use App\Http\Controllers\PD\Api\ExpFormulaController as ApiExpFormulaController;


use App\Http\Controllers\PD\AdjSalForecastController;
use App\Http\Controllers\PD\Api\AdjSalForecastController as ApiAdjSalForecastController;

// PDP0011
use App\Http\Controllers\PD\SubstituteTobaccoController;
use App\Http\Controllers\PD\Api\SubstituteTobaccoController as ApiSubstituteTobaccoController;

use App\Http\Controllers\PD\ExpFmlController;
use App\Http\Controllers\PD\Api\ExpFmlController as ApiExpFmlController;


use App\Http\Controllers\PD\SmlCostFmlController;
use App\Http\Controllers\PD\Api\SmlCostFmlController as ApiSmlCostFmlController;

use App\Http\Controllers\PD\LldController;
use App\Http\Controllers\PD\Api\LldController as ApiLldController;
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

require base_path('routes/settings/_pd.php');

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {

});

Route::group(['namespace' => 'Setting', 'prefix' => 'setting', 'as' => 'settings.'], function () {

    // Route::get('lookup', [SettingLookupController::class, 'index'])->name('lookup.index');
    // Route::get('lookup/create', [SettingLookupController::class, 'create'])->name('lookup.create');
    // Route::post('lookup', [SettingLookupController::class, 'store'])->name('lookup.store');
    // Route::get('lookup/{lookup}/edit', [SettingLookupController::class, 'edit'])->name('lookup.edit');
    // Route::put('lookup/{lookup}', [SettingLookupController::class, 'update'])->name('lookup.update');
    // Route::delete('lookup/{lookup}', [SettingLookupController::class, 'destroy'])->name('lookup.delete');

    //set-up
    Route::get('set-up', [ProgramColumnController::class, 'index'])->name('set-up.index');
    Route::get('set-up/{program_code}/show', [ProgramColumnController::class, 'show'])->name('set-up.show');
    Route::post('set-up/{program_code}/{column_name}', [ProgramColumnController::class, 'update'])->name('set-up.update');


    // //กำหนดวัตถุดิบจำลอง
    // Route::get('simu-raw-material', [SimuRawMaterialController::class, 'index'])->name('simu-raw-material.index');
    // Route::get('simu-raw-material/create', [SimuRawMaterialController::class, 'create'])->name('simu-raw-material.create');
    // Route::post('simu-raw-material', [SimuRawMaterialController::class, 'store'])->name('simu-raw-material.store');
    // Route::get('simu-raw-material/{simu_raw_id}/edit', [SimuRawMaterialController::class, 'edit'])->name('simu-raw-material.edit');
    // Route::put('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'update'])->name('simu-raw-material.update');
    // Route::delete('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'destroy'])->name('simu-raw-material.delete');
    // Route::get('simu-raw-material/{simu_raw_id}/create-inv', [SimuRawMaterialController::class, 'createInv'])->name('simu-raw-material.createInv');

});


 Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {

    // New PDP0003
    Route::prefix('sml-cost-fmls')->name('sml-cost-fmls.')->group(function () {
        Route::get('get-lines',             [ApiSmlCostFmlController::class, 'getLines'])->name('get-lines');
        Route::get('get-data',              [ApiSmlCostFmlController::class, 'getData'])->name('get-data');
        Route::post('compare-data',         [ApiSmlCostFmlController::class, 'compareData'])->name('compare-data');
        Route::post('store',                [ApiSmlCostFmlController::class, 'store'])->name('store');
        Route::post('set-status/{header}', [ApiSmlCostFmlController::class, 'setStatus'])->name('set-status');
    });

    // New PDP0008
    Route::prefix('exp-fmls')->name('exp-fmls.')->group(function () {
        Route::get('get-lines',             [ApiExpFmlController::class, 'getLines'])->name('get-lines');
        Route::get('get-data',              [ApiExpFmlController::class, 'getData'])->name('get-data');
        Route::post('compare-data',         [ApiExpFmlController::class, 'compareData'])->name('compare-data');
        Route::post('store',                [ApiExpFmlController::class, 'store'])->name('store');
        Route::post('set-status/{header}', [ApiExpFmlController::class, 'setStatus'])->name('set-status');
    });

    // New PDP0011
    Route::prefix('substitute-tobaccos')->name('substitute-tobaccos.')->group(function () {
        Route::get('get-lines',             [ApiSubstituteTobaccoController::class, 'getLines'])->name('get-lines');
        Route::get('get-data',              [ApiSubstituteTobaccoController::class, 'getData'])->name('get-data');
        Route::post('compare-data',         [ApiSubstituteTobaccoController::class, 'compareData'])->name('compare-data');
        Route::post('store',                [ApiSubstituteTobaccoController::class, 'store'])->name('store');
        Route::post('set-status/{header}', [ApiSubstituteTobaccoController::class, 'setStatus'])->name('set-status');
    });

    // PDP0013
    Route::prefix('adj-sal-forecasts')->name('adj-sal-forecasts.')->group(function () {
        Route::post('store',                [ApiAdjSalForecastController::class, 'store'])->name('store');
        Route::post('{adjSalForecastHT}/update', [ApiAdjSalForecastController::class, 'update'])->name('update');
        Route::post('{adjSalForecastHT}/duplicate',  [ApiAdjSalForecastController::class, 'duplicate'])->name('duplicate');
        Route::get('modal-create-details',  [ApiAdjSalForecastController::class, 'modalCreateDetail'])->name('modal-create-details');
        Route::get('modal-search-details',  [ApiAdjSalForecastController::class, 'modalSearchDetail'])->name('modal-search-details');
    });

    // PDP0012
    Route::prefix('lld')->name('lld.')->group(function () {
        Route::post('store',                [ApiLldController::class, 'store'])->name('store');
        Route::post('update',               [ApiLldController::class, 'update'])->name('update');
        Route::post('find-data-lov',        [ApiLldController::class, 'findDataLov'])->name('findDataLov');
        Route::post('find-item-code',       [ApiLldController::class, 'findItemCode'])->name('findItemCode');
    });
});

// New PDP0003
 Route::prefix('sml-cost-fmls')->name('sml-cost-fmls.')->group(function () {
    Route::get('/', [SmlCostFmlController::class, 'index'])->name('index');
});

// New PDP0008
Route::prefix('exp-fmls')->name('exp-fmls.')->group(function () {
    Route::get('/', [ExpFmlController::class, 'index'])->name('index');
});

// New PDP0011
Route::prefix('substitute-tobaccos')->name('substitute-tobaccos.')->group(function () {
    Route::get('/', [SubstituteTobaccoController::class, 'index'])->name('index');
});

// PDP0013
Route::prefix('adj-sal-forecasts')->name('adj-sal-forecasts.')->group(function () {
    Route::get('/', [AdjSalForecastController::class, 'index'])->name('index');
});


// New PDP0012
 Route::prefix('lld')->name('lld.')->group(function () {
    Route::get('/', [LldController::class, 'index'])->name('index');
});