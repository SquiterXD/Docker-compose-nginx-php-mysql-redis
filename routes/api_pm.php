<?php

use App\Http\Controllers\PM\Api\LookupController;
use App\Http\Controllers\PM\Api\PM0001ApiController;
use App\Http\Controllers\PM\Api\PM0005_2ApiController;
use App\Http\Controllers\PM\Api\PM0005ApiController;
use App\Http\Controllers\PM\Api\PM0006ApiController;
use App\Http\Controllers\PM\Api\PM0007ApiController;
use App\Http\Controllers\PM\Api\PM0008ApiController;
use App\Http\Controllers\PM\Api\PM0010ApiController;
use App\Http\Controllers\PM\Api\PM0011ApiController;
use App\Http\Controllers\PM\Api\PM0018ApiController;
use App\Http\Controllers\PM\Api\PM0019ApiController;
use App\Http\Controllers\PM\Api\PM0020ApiController;
use App\Http\Controllers\PM\Api\PM0021ApiController;
use App\Http\Controllers\PM\Api\PM0022ApiController;
use App\Http\Controllers\PM\Api\PM0023ApiController;
use App\Http\Controllers\PM\Api\PM0025ApiController;
use App\Http\Controllers\PM\Api\PM0027ApiController;
use App\Http\Controllers\PM\Api\PM0028ApiController;
use App\Http\Controllers\PM\Api\PM0029ApiController;
use App\Http\Controllers\PM\Api\PM0030ApiController;
use App\Http\Controllers\PM\Api\PM0031ApiController;
use App\Http\Controllers\PM\Api\PM0032ApiController;
use App\Http\Controllers\PM\Api\PM0033ApiController;
use App\Http\Controllers\PM\Api\PM0036ApiController;
use App\Http\Controllers\PM\Api\PM0038ApiController;
use App\Http\Controllers\PM\Api\PM0041ApiController;
use App\Http\Controllers\PM\Api\PM0042ApiController;
use App\Http\Controllers\PM\Api\PM0043ApiController;
use App\Http\Controllers\PM\Api\PM0045ApiController;
use App\Http\Controllers\PM\Api\TestPatController;
use App\Http\Controllers\PM\Api\TransactionPkgProductAPIController;
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

// Route::get('/lookup/{table}', [LookupController::class, 'lookupView'])->name('lookup');

//=== PM-0001 =================================================================
foreach (['0001', 'production-order'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/search', [PM0001ApiController::class, 'search'])->name('search');
        Route::get('/uom', [PM0001ApiController::class, 'uom'])->name('uom');
        Route::post('/', [PM0001ApiController::class, 'store'])->name('store');
        Route::put('/', [PM0001ApiController::class, 'update'])->name('update');
    });
}

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::get('batchStatus', [PM0001ApiController::class, 'batchStatus'])->name('production-order.batchStatus');
    Route::get('jobType', [PM0001ApiController::class, 'jobType'])->name('production-order.jobType');
});

//=== PM-0005 =================================================================
foreach (['0005', 'request-materials'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('index/{id?}', [PM0005ApiController::class, 'index'])->name('index');
        Route::get('lines/{id?}', [PM0005ApiController::class, 'lines'])->name('lines');
        Route::post('save', [PM0005ApiController::class, 'save'])->name('save');
        Route::post('confirmTransfer', [PM0005ApiController::class, 'confirmTransfer'])->name('confirmTransfer');
    });
}
foreach (['0005-2'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('index/{id?}', [PM0005_2ApiController::class, 'index'])->name('index');
        Route::get('lines/{id?}', [PM0005_2ApiController::class, 'lines'])->name('lines');
        Route::post('save', [PM0005_2ApiController::class, 'save'])->name('save');
        Route::post('confirmTransfer', [PM0005_2ApiController::class, 'confirmTransfer'])->name('confirmTransfer');
    });
}

//=== PM-0006 =================================================================
foreach (['0006', 'report-product-in-process'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/jobs', [PM0006ApiController::class, 'showJobs'])->name('jobs.index');
        Route::get('/jobs/{batchNo}', [PM0006ApiController::class, 'showJob'])->name('jobs.show');
        Route::get('/jobLines', [PM0006ApiController::class, 'showJobLines'])->name('jobLines.show');
        Route::put('/jobLines', [PM0006ApiController::class, 'updateJobLines'])->name('jobLines.update');
        Route::post('/importMesData/{id}', [PM0006ApiController::class, 'importMesData'])->name('importMesData');
    });
}

//=== PM-0007 =================================================================
foreach (['0007', 'cut-raw-material'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0007ApiController::class, 'show'])->name("show");
        Route::get('/lookupTransactionDate', [PM0007ApiController::class, 'lookupTransactionDate'])->name("lookupTransactionDate");
        Route::post('/save', [PM0007ApiController::class, 'save'])->name("save");
        Route::post('/cutIssue', [PM0007ApiController::class, 'cutIssue'])->name("cutIssue");
    });
}

//=== PM-0008 =================================================================
// Route::resource('pm0025', PM0030ApiController::class)->only(['update']);
Route::post('pm0008', [PM0008ApiController::class, 'show']);

//=== PM-0010 =================================================================
foreach (['review-complete', '0011'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0010ApiController::class, 'index'])->name('index');
        Route::get('/search', [PM0010ApiController::class, 'search'])->name('search');
        Route::post('/save', [PM0010ApiController::class, 'save'])->name('save');
    });
}

//=== PM-0011 =================================================================
foreach (['planning-job-lines', '0011'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('lines', [PM0011ApiController::class, 'getLines'])->name('lines');
        Route::get('lookupBlendNo', [PM0011ApiController::class, 'lookupBlendNo'])->name('lookupBlendNo');
        Route::put('updateLines', [PM0011ApiController::class, 'updateLines'])->name('updateLines');
    });
}

//=== PM-0018 =================================================================
foreach (['0018'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0018ApiController::class, 'show']);
    });
}

//=== PM-0019 =================================================================
foreach (['0019'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0019ApiController::class, 'index']);
        Route::post('/', [PM0019ApiController::class, 'store']);
        Route::put('/{id}', [PM0019ApiController::class, 'update']);
    });
}

//=== PM-0020 =================================================================
foreach (['0020', 'machine-ingredient-requests'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{id}', [PM0020ApiController::class, 'show'])->name("show");
        Route::put('/{id}', [PM0020ApiController::class, 'update'])->name("update");
        Route::post('/', [PM0020ApiController::class, 'store'])->name("store");

        Route::delete('/lines', [PM0020ApiController::class, 'deleteLines'])->name("lines");
    });
}

//=== PM-0021 =================================================================
foreach (['0021', 'ingredient-requests'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0021ApiController::class, 'index'])->name("index");
    });
}

//=== PM-0022 =================================================================
foreach (['0022', 'ingredient-preparation-list'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0022ApiController::class, 'index'])->name("index");
        Route::get('/reports/{id}', [PM0022ApiController::class, 'showReport'])->name("reports");
        //Route::post('', [PM0022ApiController::class, 'test'])->name("store");
    });
}

//=== PM-0023 =================================================================
foreach (['0023', 'transaction-pnk-check-material'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/rawMaterials/{id}', [PM0023ApiController::class, 'showRawMaterial'])->name("rawMaterials");
        Route::get('/compareRawMaterials', [PM0023ApiController::class, 'compareRequestAndOnShelfRawMaterial'])->name("compareRawMaterials");
    });
}

//=== PM-0025 =================================================================
// Route::resource('pm0025', PM0030ApiController::class)->only(['update']);
Route::put('pm0025/{id}', [PM0025ApiController::class, 'update']);

//=== PM-0027 =================================================================
foreach (['0027', 'sample-cigarettes'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0027ApiController::class, 'index'])->name("index");
        Route::get('/{date}', [PM0027ApiController::class, 'show'])->name('show');
        Route::put('/{date}', [PM0027ApiController::class, 'update'])->name('update');
        Route::delete('/', [PM0027ApiController::class, 'delete'])->name('delete');
    });
}

//=== PM-0028 =================================================================
foreach (['0028', 'free-products'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{date}', [PM0028ApiController::class, 'getProductByDate'])->name('getProductByDate');
        Route::put('/{date}', [PM0028ApiController::class, 'update'])->name('update');
        Route::delete('/', [PM0028ApiController::class, 'deleteLine'])->name('deleteLines');
    });
}

//=== PM-0029 =================================================================
Route::post('pm0029', [PM0029ApiController::class, 'show']);

//=== PM-0030 =================================================================
// Route::resource('pm0030', PM0030ApiController::class)->only(['update']);
Route::put('pm0030/{id}', [PM0030ApiController::class, 'update']);
Route::put('transaction-pkg-product', TransactionPkgProductAPIController::class);

//=== PM-0031 =================================================================
foreach (['0031'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0031ApiController::class, 'index'])->name('index');
        Route::get('get-batches', [PM0031ApiController::class, 'getBatches'])->name('get-batches');
        Route::get('get-list-batch-headers', [PM0031ApiController::class, 'getListBatchHeaders'])->name('get-list-batch-headers');
        Route::get('get-wip-steps', [PM0031ApiController::class, 'getWipSteps'])->name('get-wip-steps');
        Route::get('search', [PM0031ApiController::class, 'search'])->name('search');
        Route::post('save', [PM0031ApiController::class, 'save'])->name('save');
    });
}

//=== PM-0032 =================================================================
foreach (['0032', 'stamp-using'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('search', [PM0032ApiController::class, 'search'])->name('search');
        Route::get('/', [PM0032ApiController::class, 'index'])->name('index');
        Route::get('/{stampHeaderId}', [PM0032ApiController::class, 'show'])->name('show');
        Route::post('/', [PM0032ApiController::class, 'store'])->name('store');
        Route::put('/{stampHeaderId}', [PM0032ApiController::class, 'update'])->name('update');

        Route::post('transfer', [PM0032ApiController::class, 'transferStamp'])->name('transferStamp');
        Route::delete('lines', [PM0032ApiController::class, 'deleteLines'])->name("deleteLines");
    });
}

//=== PM-0033 =================================================================
foreach (['0033', 'confirm-stamp-using'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0033ApiController::class, 'getIndex'])->name("get");
        Route::put('/', [PM0033ApiController::class, 'updateStampUsage'])->name("update-stamp-usage");
        Route::put('/useStamp', [PM0033ApiController::class, 'useStamp'])->name("use-stamp");
    });
}

//=== PM-0036 =================================================================
foreach (['0036', 'close-product-order'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0036ApiController::class, 'index'])->name("index");
        Route::get('/jobOptRelations', [PM0036ApiController::class, 'getJobOptRelations'])->name("job-opt-relations");
        Route::post('/closeBatch', [PM0036ApiController::class, 'execCloseBatch'])->name("close-batch");
    });
}

//=== PM-0038 =================================================================
foreach (['0038'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::put('/close-job', [PM0038ApiController::class, 'close_job']);
        Route::put('/cancel-close-job', [PM0038ApiController::class, 'cancelCloseJob'])->name("cancel-close-job");
        Route::get('/product-detail', [PM0038ApiController::class, 'productDetail'])->name("product-detail");
    });
}


//=== PM-0041 =================================================================
foreach (['0041', 'examine-casing-after-expiry-date'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0041ApiController::class, 'index'])->name('index');
        Route::put('/updateExamineCasing', [PM0041ApiController::class, 'updateExamineCasing'])->name('updateExamineCasing');
        Route::put('/updateExpirationDate', [PM0041ApiController::class, 'updateExpirationDate'])->name('updateExpirationDate');
    });
}

//=== PM-0042 =================================================================
foreach (['0042'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0042ApiController::class, 'index'])->name("index");
        Route::put('/approveRequest', [PM0042ApiController::class, 'approveRequest'])->name("approveRequest");
        Route::put('/rejectRequest', [PM0042ApiController::class, 'rejectRequest'])->name("rejectRequest");
    });
}

//=== PM-0043 =================================================================
foreach (['0043'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{id}', [PM0043ApiController::class, 'show']);
        Route::post('/', [PM0043ApiController::class, 'store']);
        Route::put('/{id}', [PM0043ApiController::class, 'update']);
        Route::delete('/', [PM0043ApiController::class, 'destroy']);
    });
}

//=== PM-0045 =================================================================
foreach (['0045', 'examine-after-manufactured'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::put('/approveRequest', [PM0045ApiController::class, 'approveRequest'])->name("approveRequest");
        Route::put('/cancelRequest', [PM0045ApiController::class, 'cancelRequest'])->name("cancelRequest");
        Route::put('/{id}', [PM0045ApiController::class, 'update']);
    });
}

//=== TESTING =================================================================
Route::get('test', function () {
    return 'ok';
});

$routeBase = 'test/pat';
Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
    //TODO remove
    Route::get('', [TestPatController::class, 'get'])->name('get');
});

//Route::group([
//    'prefix' => 'test',
//    'middleware' => ['api'],
//], function () {
//
//    Route::get('a', function () {
//        $o = \App\Models\PM\PtpmRequestHeader::query()->create([
//            'request_number' => 111,
//        ]);
//        return [
//            'o' => $o,
//        ];
//    });
//    Route::get('h', function () {
//        $header = PtpmStampHeader::query()->create([
//            'machine_group' => 111,
//            'used_date' => '2021-02-26 06:46:28',
//            'description1' => 'ทดสอบ',
//        ]);
//        return [
//            'header' => $header,
//        ];
//    });
//    Route::get('l', function () {
//        $line = PtpmStampLine::query()->create([
//            'machine_group' => 1111,
////            'inventory_item_id' => 17734,
////            'organization_id' => 121,
////            'description1' => 'SMS แดง',
////            'used_date' => '2021-02-19',
////            'core_code' => 5614,
////            'roll_num' => 1,
////            'last_number' => 224560000,
////            'current_number' => 224540000,
////            'empty' => 'N',
////            'remaining' => 20000,
//            'stamp_header_id' => 63,
//        ]);
////        $line = PtpmStampLine::query()->where('machine_group', 1111)->first();
////        $line->stamp_header_id = 33;
////        $line->save();
//        return [
//            'line' => $line,
//        ];
//    });
//});
