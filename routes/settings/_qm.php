<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController;
use App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController;

use App\Http\Controllers\QM\Settings\TestUnitController;

use App\Http\Controllers\QM\Settings\QcAreaController;

use App\Http\Controllers\QM\Settings\DefineTestsTobaccoLeafController;
use App\Http\Controllers\QM\Settings\DefineTestsTobaccoBeetleController;
use App\Http\Controllers\QM\Settings\DefineTestsFinishedProductsController;
use App\Http\Controllers\QM\Settings\DefineTestsQTMMachinesController;
use App\Http\Controllers\QM\Settings\DefineTestsPacketAirLeaksController;
use App\Http\Controllers\QM\Settings\AttachmentController;
use App\Http\Controllers\QM\Settings\QualityAssuranceController;
use App\Http\Controllers\QM\Settings\Ajax\QualityAssuranceController as AjaxQualityAssuranceController;
use App\Http\Controllers\QM\Settings\Ajax\DefineTestsFinishedProductsController as AjaxDefineTestsFinishedProductsController;


use App\Http\Controllers\QM\Settings\SpecificationController;
use App\Http\Controllers\QM\Api\Settings\SpecificationController as ApiSpecificationController;

use App\Http\Controllers\QM\Settings\ResultSeverityController;

use App\Http\Controllers\QM\Settings\QcAreaQTMController;
use App\Http\Controllers\QM\Settings\QcAreaLeakRateController;
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

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::post('quality-assurance/get-table-results', [AjaxQualityAssuranceController::class, 'getTableResults'])->name('quality-assurance.getTableResults');
    Route::post('quality-assurance/update', [AjaxQualityAssuranceController::class, 'update'])->name('quality-assurance.update');
    Route::prefix('attachments')->name('attachments.')->group(function () {
        Route::get('/{attachment}/{testTypeCode}/deleteByPKGDefineTests', [AttachmentController::class, 'deleteByPKGDefineTests']);
        Route::get('/{attachment}/{programCode}/deleteByPKGCheckPoints', [AttachmentController::class, 'deleteByPKGCheckPoints']);
    });
});

Route::namespace('Api')->prefix('api')->name('api.')->group(function () {

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::prefix('specifications')->name('specifications.')->group(function () {
            Route::post('/', [ApiSpecificationController::class, 'store'])->name('store');
        });
    });

});

Route::prefix('settings')->name('settings.')->group(function () {

    Route::prefix('specifications')->name('specifications.')->group(function () {
        Route::get('/', [SpecificationController::class, 'index'])->name('index');
    });

    Route::get('result-severity', [ResultSeverityController::class, 'index'])->name('result-severity.index');
    Route::post('result-severity', [ResultSeverityController::class, 'store'])->name('result-severity.store');

    Route::get('check-points-tobacco-leaf', [CheckPointsTobaccoLeafController::class, 'index'])->name('check-points-tobacco-leaf.index');
    Route::get('check-points-tobacco-leaf/create', [CheckPointsTobaccoLeafController::class, 'create'])->name('check-points-tobacco-leaf.create');
    Route::post('check-points-tobacco-leaf/store', [CheckPointsTobaccoLeafController::class, 'store'])->name('check-points-tobacco-leaf.store');
    Route::post('check-points-tobacco-leaf/update', [CheckPointsTobaccoLeafController::class, 'update'])->name('check-points-tobacco-leaf.update');
    Route::get('check-points-tobacco-leaf/{id}/edit', [CheckPointsTobaccoLeafController::class, 'edit'])->name('check-points-tobacco-leaf.edit');

    Route::get('check-points-tobacco-beetle', [CheckPointsTobaccoBeetleController::class, 'index'])->name('check-points-tobacco-beetle.index');
    Route::get('check-points-tobacco-beetle/create', [CheckPointsTobaccoBeetleController::class, 'create'])->name('check-points-tobacco-beetle.create');
    Route::post('check-points-tobacco-beetle/store', [CheckPointsTobaccoBeetleController::class, 'store'])->name('check-points-tobacco-beetle.store');
    Route::get('check-points-tobacco-beetle/{id}/edit', [CheckPointsTobaccoBeetleController::class, 'edit'])->name('check-points-tobacco-beetle.edit');
    Route::post('check-points-tobacco-beetle/update', [CheckPointsTobaccoBeetleController::class, 'update'])->name('check-points-tobacco-beetle.update');

    Route::get('test-unit', [TestUnitController::class, 'index'])->name('test-unit.index');
    Route::get('test-unit/create', [TestUnitController::class, 'create'])->name('test-unit.create');
    Route::get('test-unit/{qcunit_code}/edit', [TestUnitController::class, 'edit'])->name('test-unit.edit');
    Route::post('test-unit/store', [TestUnitController::class, 'store'])->name('test-unit.store');
    Route::put('test-unit/update', [TestUnitController::class, 'update'])->name('test-unit.update');
    
    Route::get('qc-area', [QcAreaController::class, 'index'])->name('qc-area.index');
    Route::put('qc-area/update', [QcAreaController::class, 'update'])->name('qc-area.update');

    Route::get('qc-area-qtm', [QcAreaQTMController::class, 'index'])->name('qc-area-qtm.index');
    Route::put('qc-area-qtm/update', [QcAreaQTMController::class, 'update'])->name('qc-area-qtm.update');

    Route::get('qc-area-leak-rate', [QcAreaLeakRateController::class, 'index'])->name('qc-area-leak-rate.index');
    Route::put('qc-area-leak-rate/update', [QcAreaLeakRateController::class, 'update'])->name('qc-area-leak-rate.update');

    Route::get('define-tests-tobacco-leaf', [DefineTestsTobaccoLeafController::class, 'index'])->name('define-tests-tobacco-leaf.index');
    Route::get('define-tests-tobacco-leaf/create', [DefineTestsTobaccoLeafController::class, 'create'])->name('define-tests-tobacco-leaf.create');
    Route::post('define-tests-tobacco-leaf/store', [DefineTestsTobaccoLeafController::class, 'store'])->name('define-tests-tobacco-leaf.store');
    Route::put('define-tests-tobacco-leaf/update', [DefineTestsTobaccoLeafController::class, 'update'])->name('define-tests-tobacco-leaf.update');

    Route::get('define-tests-tobacco-beetle', [DefineTestsTobaccoBeetleController::class, 'index'])->name('define-tests-tobacco-beetle.index');
    Route::get('define-tests-tobacco-beetle/create', [DefineTestsTobaccoBeetleController::class, 'create'])->name('define-tests-tobacco-beetle.create');
    Route::post('define-tests-tobacco-beetle/store', [DefineTestsTobaccoBeetleController::class, 'store'])->name('define-tests-tobacco-beetle.store');
    Route::put('define-tests-tobacco-beetle/update', [DefineTestsTobaccoBeetleController::class, 'update'])->name('define-tests-tobacco-beetle.update');

    Route::get('define-tests-finished-products', [DefineTestsFinishedProductsController::class, 'index'])->name('define-tests-finished-products.index');
    Route::get('define-tests-finished-products/create', [DefineTestsFinishedProductsController::class, 'create'])->name('define-tests-finished-products.create');
    Route::post('define-tests-finished-products/store', [DefineTestsFinishedProductsController::class, 'store'])->name('define-tests-finished-products.store');
    Route::put('define-tests-finished-products/update', [DefineTestsFinishedProductsController::class, 'update'])->name('define-tests-finished-products.update');

    Route::get('define-tests-qtm-machines', [DefineTestsQTMMachinesController::class, 'index'])->name('define-tests-qtm-machines.index');
    Route::get('define-tests-qtm-machines/create', [DefineTestsQTMMachinesController::class, 'create'])->name('define-tests-qtm-machines.create');
    Route::post('define-tests-qtm-machines/store', [DefineTestsQTMMachinesController::class, 'store'])->name('define-tests-qtm-machines.store');
    Route::put('define-tests-qtm-machines/update', [DefineTestsQTMMachinesController::class, 'update'])->name('define-tests-qtm-machines.update');

    Route::get('define-tests-packet-air-leaks', [DefineTestsPacketAirLeaksController::class, 'index'])->name('define-tests-packet-air-leaks.index');
    Route::get('define-tests-packet-air-leaks/create', [DefineTestsPacketAirLeaksController::class, 'create'])->name('define-tests-packet-air-leaks.create');
    Route::post('define-tests-packet-air-leaks/store', [DefineTestsPacketAirLeaksController::class, 'store'])->name('define-tests-packet-air-leaks.store');
    Route::put('define-tests-packet-air-leaks/update', [DefineTestsPacketAirLeaksController::class, 'update'])->name('define-tests-packet-air-leaks.update');

    Route::prefix('attachments')->name('attachments.')->group(function () {
        Route::get('/{attachment}/download', [AttachmentController::class, 'download'])->name('download');
        Route::get('/{attachment}/{testTypeCode}/imageDefineTests', [AttachmentController::class, 'imageDefineTests']);
        Route::get('/{attachment}/imageCheckPoints', [AttachmentController::class, 'imageCheckPoints']);
    });

    Route::get('quality-assurance', [QualityAssuranceController::class, 'index'])->name('quality-assurance.index');
    Route::get('quality-assurance/create', [QualityAssuranceController::class, 'create'])->name('quality-assurance.create');
    Route::post('quality-assurance/store', [QualityAssuranceController::class, 'store'])->name('quality-assurance.store');
    
});
