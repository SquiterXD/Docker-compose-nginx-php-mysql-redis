<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PM\ConfirmOrderController;
// use App\Http\Controllers\PM\Ajax\ConfirmOrderController as AjaxConfirmOrderController;
use App\Http\Controllers\PM\TestReportController;
use App\Http\Controllers\PM\Ajax\TestReportController as AjaxTestReportController;
use App\Http\Controllers\PM\ConfirmLossOrderController;
use App\Http\Controllers\PM\Ajax\ConfirmLossOrderController as AjaxConfirmLossOrderController;


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


Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::post('confirm-order', [AjaxConfirmLossOrderController::class, 'store'])->name('confirm-order.store');
    Route::get('confirm-order/get-lines',[AjaxConfirmLossOrderController::class,'getLine'])->name('confirm-order.get-lines');
    Route::get('confirm-order/get-distributions',[AjaxConfirmLossOrderController::class,'getDistribution'])->name('confirm-order.get-distributions');
    Route::get('confirm-order/get-wipstep',[AjaxConfirmLossOrderController::class,'getWipStep'])->name('confirm-order.get-wipstep');
    Route::get('confirm-order/get-search',[AjaxConfirmLossOrderController::class,'getSearch'])->name('confirm-order.get-search');
    Route::get('confirm-order/get-headers-by-date',[AjaxConfirmLossOrderController::class,'getHeaderByDate'])->name('confirm-order.get-headers-by-date');
    Route::patch('confirm-order-update',[AjaxConfirmLossOrderController::class,'update'])->name('confirm-order.update-orders');
//    Route::get('sample-report2/get-items',[AjaxTestReportController::class,'getItems'])->name('sample-report2.get-items');
});


Route::middleware(['auth'])->group(function () {
//    Route::get('confirm-order-n', [ConfirmOrderController::class, 'index'])->name('confirm-order.index-n');
    Route::get('confirm-order', [ConfirmLossOrderController::class, 'index'])->name('confirm-order.index');

    Route::get('sample-report/{number}', [TestReportController::class, 'report'])->name('sample-report.report');
    Route::get('sample-report1-pdf/{number}', [TestReportController::class, 'report1Pdf'])->name('sample-report.report1-pdf');
    Route::get('sample-report-inventory-pdf/{batchNo}/{departmentCode}/{txnDate}', [TestReportController::class, 'reportInventory'])->name('sample-report.report-inventory-pdf');
    Route::get('sample-report-summary-pdf/{departmentCode}/{startDate}/{endDate}', [TestReportController::class, 'reportMasterList'])->name('sample-report.report-summary-pdf');
    Route::get('sample-report-vue', [TestReportController::class, 'reportVue'])->name('sample-report.report-vue');
    Route::get('sample-report1', [TestReportController::class, 'report1'])->name('sample-report.report1');
    Route::get('sample-report2', [TestReportController::class, 'report2'])->name('sample-report.report2');
    Route::get('test-pdf', [TestReportController::class, 'testPdf'])->name('sample-report.testPdf');
//    Route::get('sample-report1', [TestReportController::class, 'report1'])->name('sample-report.report1');
//    Route::get('sample-report1-pdf', [TestReportController::class, 'report1Pdf'])->name('sample-report.report1-pdf');
//    Route::get('sample-report2', [TestReportController::class, 'report2'])->name('sample-report.report2');

    Route::get('user',function (){
        $data = getDefaultData('/users');
        return response()->json($data);
    });

    Route::get('userProfile',function (){
        $userProfile = getDefaultData('/pm/confirm-order');
        return response()->json($userProfile);
    });

    Route::get('header',function (){
        $headers = \App\Models\PM\PtmesProductHeaderv::all();

        return $headers;
    });
});


