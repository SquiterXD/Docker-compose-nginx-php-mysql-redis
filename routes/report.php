<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PM\WipIssuesController;
use App\Http\Controllers\Report\ReportsController;
use App\Http\Controllers\Report\Ajax\ReportsController as AjaxReportsController;
use App\Http\Controllers\IR\Settings\ReportInfoController;
use App\Http\Controllers\IR\Ajax\IrReportsController;





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
    Route::get('get-report-programs', [AjaxReportsController::class, 'getReportProgram'])->name('get-report-programs');
    Route::get('report-get-sub-query', [AjaxReportsController::class, 'getSubQuery'])->name('report-get-sub-query');
    Route::get('report-get-info', [IrReportsController::class, 'getInfo'])->name('report-get-info');
    Route::get('report-get-info-attribute', [IrReportsController::class, 'getInfoAttribute'])->name('report-get-info-attribute');

    Route::get('ir-report-submit', [IrReportsController::class, 'irReportSubmit'])->name('ir-report-submit');
    Route::get('get-dependent', [ReportInfoController::class, 'getDependent'])->name('get-dependent');
    // Route::get('get-opt-from-blend-no', [WipIssuesApiController::class, 'getOptsFromBlends'])->name('opt-from-blend-no');
    // Route::get('get-oprn-by-item', [WipIssuesApiController::class, 'getOprnByItem'])->name('get-oprn-by-item');
    // Route::get('get-formulas', [WipIssuesApiController::class, 'getFormula'])->name('get-formulas');
    // Route::post('save-data', [WipIssuesApiController::class, 'saveData'])->name('save-data');
    // Route::post('update-data', [WipIssuesApiController::class, 'updateData'])->name('update-data');
    // Route::get('find-classification', [WipIssuesApiController::class, 'findClassification'])->name('find-classification');
    // Route::get('get-headers', [WipIssuesApiController::class, 'getHeaders'])->name('get-headers');
    // Route::post('cancel-data', [WipIssuesApiController::class, 'cancelData'])->name('cancel-data');
    // Route::get('search-header', [WipIssuesApiController::class, 'searchHeader'])->name('search-header');

});


Route::prefix('report-info')->name('report-info.')->group(function () {
    route::get('/dev',  function() {
        $roles = \App\Models\Role::whereIn('rosle_id', auth()->user()->role_options)
        ->pluck('module_name');
        dd($roles );
        dd(
            \DB::connection('oracle')->getDatabaseName(),
            getDefaultData(\Request::path()),
            $roles

        );

    });
    Route::get('/', [ReportsController::class, 'index'])->name('index');

    Route::get('reports/export', [ReportsController::class, 'export'])->name('report.export');
    Route::get('reports', [ReportsController::class, 'index'])->name('report.index');
    Route::get('reports/get-param', [ReportsController::class, 'getParam'])->name('report.get-param');


    Route::get('report-info', [ReportInfoController::class, 'index'])->name('report-info.index');
    Route::get('report-info/{program}', [ReportInfoController::class, 'show'])->name('report-info.show');
    Route::post('report-info/{program}/store', [ReportInfoController::class, 'store'])->name('report-info.store');
    Route::post('report-info/{program}/{info}', [ReportInfoController::class, 'update'])->name('report-info.update');
    Route::post('report-info/{program}/{info}/delete', [ReportInfoController::class, 'destroy'])->name('report-info.destroy');
    Route::post('report-info/{program}/save/function', [ReportInfoController::class, 'saveFunction'])->name('save-function');

    Route::get('report-info-copy/copy-program/{program}/{program_to}', [ReportInfoController::class, 'copy'])->name('save-copy');
    //

});

// Route::prefix('wip-issue')->name('wip-issue.')->group(function () {

//     // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
// });




