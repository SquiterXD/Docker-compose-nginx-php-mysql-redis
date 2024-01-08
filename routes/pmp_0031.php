<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PM\Api\PMP0031ApiController;
use App\Http\Controllers\PM\PMP0031Controller;

use App\Models\PM\PtmpSalesForecast;
use App\Models\Lookup\PtBiweeklyLookup;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtmpProductPlanHeader;
use App\Models\PM\PtmpProductPlanLine;
use App\Models\PM\Lookup\PtpmItemNumberV;

// use DB;
// use PDO;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------p\js\components\pm\pmp0031\Index.vue
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
    Route::post('pmp0031/process', [PMP0031ApiController::class, 'process'])->name('pmp0031.process');
    Route::get('pmp0031/get-sale-forecasts', [PMP0031ApiController::class, 'getSaleForecasts'])->name('get-sale-forecasts');
    Route::get('pmp0031/get-biweeklies', [PMP0031ApiController::class, 'getBiweeklies'])->name('get-biweeklies');
    Route::post('pmp0031/open-Job', [PMP0031ApiController::class, 'openJob'])->name('pmp0031.open-Job');

    // Route::get('get-mes-review-issues', [WipIssuesApiController::class, 'getMesReviewIssuesV'])->name('get-me-review-issues-v');
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


Route::prefix('pmp_0031')->name('pmp-0031.')->group(function () {
    Route::get('/', [PMP0031Controller::class, 'index'])->name('index');

    // Route::get('/dev-test', function () {

    //     $productPlanLine =  PtmpProductPlanLine::where('plan_line_id', 661)->first();
    //     $productPlanLine->uom2 = 'PTN';
    //     $productPlanLine->period_name_request = 60000;
    //     $productPlanLine->attribute15 = true;
    //     $productPlanLine->save();

    //         $db     =   DB::connection('oracle')->getPdo();
    //             $sql    =   "
    //                 DECLARE
    //                     V_RESULT VARCHAR2 (4000);
    //                     BEGIN
    //                             V_RESULT := ptpm_create_report_pkg.REQUEST (
    //                                 P_SOURCE_TABLE => 'PTPM_PRODUCT_PLAN_H',
    //                                 P_SOURCE_ID => '661',
    //                                 P_QTY => '60000',
    //                                 P_UOM => 'PTN',
    //                                 P_USER_ID => '1110');
    //                     END;
    //                             ";
    //         $sql = preg_replace("/[\r\n]*/", "", $sql);
    //         $stmt = $db->prepare($sql);
    //         $stmt->execute();


    //     dd('xxx');
    // });
    // Route::get('/casing-flavor', [WipIssuesController::class, 'casingFlavorIndex'])->name('casing-flavor-index');
    // Route::get('/issue', [WipIssuesController::class, 'wipIssueAll'])->name('issue');
    // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
});



// Route::prefix('wip-issue')->name('wip-issue.')->group(function () {

//     // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
// });




