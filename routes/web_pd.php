<?php

use App\Http\Controllers\PD\Web\PD0001Controller;
use App\Http\Controllers\PD\Web\PD0002Controller;
use App\Http\Controllers\PD\Web\PD0003Controller;
use App\Http\Controllers\PD\Web\PD0004Controller;
use App\Http\Controllers\PD\Web\PD0005Controller;
use App\Http\Controllers\PD\Web\PD0006Controller;
use App\Http\Controllers\PD\Web\PD0007Controller;
use App\Http\Controllers\PD\Web\PD0008Controller;
use App\Http\Controllers\PD\Web\PD0010Controller;
use App\Http\Controllers\PD\Web\PD0011Controller;
use App\Http\Controllers\PD\Web\PD0012Controller;
use App\Http\Controllers\PD\Web\PD0013Controller;
use App\Http\Controllers\PD\Web\PD0014Controller;
use App\Http\Controllers\PD\Web\PDP0015Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PD\Web\InvMaterialItemController;
use App\Http\Controllers\PD\Web\PD0009Controller;

use App\Http\Controllers\PD\Api\PD0014ApiController;
use App\Http\Controllers\PD\Api\PD0015ApiController;

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
    /// PD 0014 ///
    Route::get('pdp0014/get-years', [PD0014ApiController::class, 'getYears'])->name('get-years');
    Route::get('pdp0014/check-number-from-year/{year}', [PD0014ApiController::class, 'checkNumberFromYear'])->name('check-number-from-year');
    Route::get('pdp0014/get-sales-fiscals', [PD0014ApiController::class, 'getSalesFiscals'])->name('get-sales-fiscals');
    Route::get('pdp0014/get-items', [PD0014ApiController::class, 'getItems'])->name('get-items');
    Route::post('pdp0014/create-line', [PD0014ApiController::class, 'createLine'])->name('create-line');
    Route::post('pdp0014/update-line/{id}', [PD0014ApiController::class, 'updateLine'])->name('update-line');
    Route::get('pdp0014/find-lines/{id}', [PD0014ApiController::class, 'findLines'])->name('find-lines');
    Route::get('pdp0014/select-header/{id}', [PD0014ApiController::class, 'selectHeader'])->name('select-header');
    Route::get('pdp0014/get-lines/{id}', [PD0014ApiController::class, 'getLines'])->name('get-lines');
    Route::get('pdp0014/search-headers', [PD0014ApiController::class, 'searchHeaders'])->name('search-headers');
    Route::get('pdp0014/search-species', [PD0014ApiController::class, 'searchSpecies'])->name('search-species');
    Route::get('pdp0014/get-temp-sales-fiscal-year-TH', [PD0014ApiController::class, 'getTempSalesFiscalYearTH'])->name('search-getTempSalesFiscalYearTH');
    Route::get('pdp0014/get-temp-sales-fiscal-year-revision', [PD0014ApiController::class, 'getTempSalesFiscalYearRevision'])->name('search-getTempSalesFiscalYearRevision');
    Route::get('pdp0014/get-temp-fiscal-year-vision', [PD0014ApiController::class, 'getTempFiscalYearVision'])->name('search-getTempFiscalYearVision');
    Route::get('pdp0014/retrieve-leaves/{id}', [PD0014ApiController::class, 'getRetrieveLeaves'])->name('get-retrieve-leaves');
    Route::get('pdp0014/get-confirm-approved/{id}', [PD0014ApiController::class, 'getConfirmApproved'])->name('get-confirm-approved');

    /// PD 0015 ///
    Route::get('pdp0015/get-items', [PD0015ApiController::class, 'getItems'])->name('get-items');
    Route::get('pdp0015/select-header/{id}', [PD0015ApiController::class, 'selectHeader'])->name('select-header');
    Route::get('pdp0015/get-headers', [PD0015ApiController::class, 'getHeader'])->name('get-headers');
    Route::get('pdp0015/get-species', [PD0015ApiController::class, 'getSpecies'])->name('get-species');
    Route::get('pdp0015/get-temp-sales-fiscal-year-TH', [PD0015ApiController::class, 'getTempSalesFiscalYearTH'])->name('search-getTempSalesFiscalYearTH');
    Route::get('pdp0015/get-temp-sales-fiscal-year-revision', [PD0015ApiController::class, 'getTempSalesFiscalYearRevision'])->name('search-getTempSalesFiscalYearRevision');
    Route::get('pdp0015/get-temp-fiscal-year-vision', [PD0015ApiController::class, 'getTempFiscalYearVision'])->name('search-getTempFiscalYearVision');
});



//=== PD-0001 =================================================================
foreach (['0001', 'casing-simu-additive'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0001Controller::class, 'index'])->name('index');
    });
}

//=== PD-0002 =================================================================
foreach (['0002', 'flavor-simu-additive'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0002Controller::class, 'index'])->name('index');
    });
}

//=== PD-0003 =================================================================
foreach (['0003', 'pd-0003'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0003Controller::class, 'index'])->name("index");
    });
}

//=== PD-0004 =================================================================
foreach (['0004', 'inv-material-items'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0004Controller::class, 'index'])->name('index');
        Route::get('/{inventoryItemId}', [PD0004Controller::class, 'show'])->name("show");
    });
}

//=== PD-0005 =================================================================
foreach (['0005', 'example-cigarettes'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0005Controller::class, 'index'])->name('index');
        Route::get('/{inventoryItemCode}', [PD0005Controller::class, 'show'])->name("show");
    });
}

//=== PD-0006 =================================================================
foreach (['0006'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0006Controller::class, 'index'])->name("index");
        Route::get('/{blendId}', [PD0006Controller::class, 'show'])->name("show");
    });
}

//=== PD-0007 =================================================================
foreach (['0007'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0007Controller::class, 'index'])->name("index");
    });
}

//=== PD-0008 =================================================================
foreach (['0008'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0008Controller::class, 'index'])->name("index");
    });
}

//=== PD-0010 =================================================================
foreach (['0010'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0010Controller::class, 'index'])->name("index");
    });
}

//=== PD-0011 =================================================================
foreach (['0011'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0011Controller::class, 'index'])->name("index");
    });
}

//=== PD-0012 =================================================================
foreach (['0012'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0012Controller::class, 'index'])->name("index");
    });
}

//=== PD-0013 =================================================================
foreach (['0013'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0013Controller::class, 'index'])->name("index");
    });
}

//=== PD-0009 =================================================================
foreach (['0009', 'expanded-tobacco'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{id?}', [PD0009Controller::class, 'index'])->name("index");
        Route::get('/test', [PD0009Controller::class, 'test'])->name("test");
    });
}

//=== PD-0014 =================================================================

Route::prefix('PDP0014')->name('pdp0014.')->group(function () {
    Route::get('/', [PD0014Controller::class, 'index'])->name("index");
});

Route::prefix('PDP0015')->name('pdp0015.')->group(function () {
    // dd('xxx');
    Route::get('/', [PDP0015Controller::class, 'index'])->name("index");
});
// foreach (['0014', 'pd-0014'] as $routeBase) {
//     dd
    // Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        
    // });
// }

//=== TESTING =================================================================
Route::get('test', function () {
    return 'ok';
});
