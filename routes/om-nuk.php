<?php
// Utility

use App\Http\Controllers\OM\Api\ClaimApproveApiController;
use Illuminate\Support\Facades\Route;

// Api
use App\Http\Controllers\OM\Api\ClaimApproveController;
use App\Http\Controllers\OM\Api\CustomerInfoController;
use App\Http\Controllers\OM\Api\CustomerSyncController;
use App\Http\Controllers\OM\Api\ReportCigarreteOrderController;
// Web
use App\Http\Controllers\OM\Web\ClaimApproveController as ClaimApproveWeb;

use App\Jobs\TestJob;

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

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('test-job', function () {
        TestJob::dispatch()->onQueue('uploadFile');
    });
    foreach (['claim/claim-approve'] as $routeBase) {
        Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
            Route::get('/', [ClaimApproveWeb::class, 'index'])->name("index");
        });
    }
    foreach (['claim/request-for-change'] as $routeBase) {
        Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
            Route::get('/', [ClaimApproveWeb::class, 'requestForChange'])->name("requestForChange");

            Route::prefix('v1')->group(function () {
                Route::get('/print-pdf', [ClaimApproveWeb::class, 'requestPdf'])->name("requestPdf");
                Route::get('/print-claim-pdf', [ClaimApproveWeb::class, 'requestClaimPdf'])->name("requestClaimPdf");
            });
        });
    }


    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/claim/get-claim-number', [ClaimApproveApiController::class, 'getClaimNumber'])->name('getClaimNumber');
        Route::post('/claim/get-claim-list', [ClaimApproveApiController::class, 'getListHeader'])->name('getListHeader');
        Route::post('/claim/get-claim-list-datatable', [ClaimApproveApiController::class, 'getListHeaderDatatable'])->name('getListHeader.datatable');
        Route::post('/claim/get-status-list', [ClaimApproveApiController::class, 'claimStatusList'])->name('claimStatusList');
        Route::post('/claim/update-header', [ClaimApproveApiController::class, 'updateHeader'])->name('updateHeader');
        Route::post('/claim/close-header', [ClaimApproveApiController::class, 'closeHeaderClaim'])->name('closeHeaderClaim');
    });
});
Route::middleware(['auth.api'])->prefix('api')->name('api.')->group(function () {
    Route::post('/customers/info', [CustomerInfoController::class, 'listCustomersInfo'])->name('customers.info');
    Route::post('/customers/info/field', [CustomerInfoController::class, 'listCustomersInfoFiled'])->name('customers.info.field');
    Route::post('/so-outstanding', [ReportCigarreteOrderController::class, 'fetchSoOutStanding']);
    Route::post('/fetch-customers', [ReportCigarreteOrderController::class, 'fetchCustomers']);

    Route::post('sync/customer/info/{cus_code}', [CustomerSyncController::class, 'getInfoCustomer']);
    Route::post('sync/customers', [CustomerSyncController::class, 'syncCustomer']);

    Route::post('/claim/get-claim-list-num', [ClaimApproveApiController::class, 'getClaimListNum'])->name('get.list-claim-num');
    Route::post('/claim/get-claim', [ClaimApproveApiController::class, 'getClaim'])->name('get.claim');
    Route::post('/claim/get-customer', [ClaimApproveApiController::class, 'getCustomer'])->name('get.list-customer');
    Route::post('/claim/list-invoice', [ClaimApproveApiController::class, 'getListInvoice'])->name('get.list-invoice');
    Route::post('/claim/get-invoice-number', [ClaimApproveApiController::class, 'getListInvoiceNumber'])->name('get.list-invoice');
    Route::post('/claim/gen-claim-doc', [ClaimApproveApiController::class, 'genarateClaimDoc'])->name('get.genarateClaimDoc');
    Route::post('/claim/status-list', [ClaimApproveApiController::class, 'claimStatusList'])->name('get.claimStatusList');
    Route::post('/claim/status-action', [ClaimApproveApiController::class, 'claimStatusAction'])->name('get.claimStatusAction');
});
