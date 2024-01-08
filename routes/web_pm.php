<?php

use App\Http\Controllers\PM\Web\ExampleDbLookupController;
use App\Http\Controllers\PM\Web\PM0001Controller;
use App\Http\Controllers\PM\Web\PM0002Controller;
use App\Http\Controllers\PM\Web\PM0003Controller;
use App\Http\Controllers\PM\Web\PM0004Controller;
use App\Http\Controllers\PM\Web\PM0005_2Controller;
use App\Http\Controllers\PM\Web\PM0005Controller;
use App\Http\Controllers\PM\Web\PM0006Controller;
use App\Http\Controllers\PM\Web\PM0007Controller;
use App\Http\Controllers\PM\Web\PM0008Controller;
use App\Http\Controllers\PM\Web\PM0009Controller;
use App\Http\Controllers\PM\Web\PM0010Controller;
use App\Http\Controllers\PM\Web\PM0011Controller;
use App\Http\Controllers\PM\Web\PM0012Controller;
use App\Http\Controllers\PM\Web\PM0013Controller;
use App\Http\Controllers\PM\Web\PM0014Controller;
use App\Http\Controllers\PM\Web\PM0015Controller;
use App\Http\Controllers\PM\Web\PM0016Controller;
use App\Http\Controllers\PM\Web\PM0017Controller;
use App\Http\Controllers\PM\Web\PM0018Controller;
use App\Http\Controllers\PM\Web\PM0019Controller;
use App\Http\Controllers\PM\Web\PM0020Controller;
use App\Http\Controllers\PM\Web\PM0021Controller;
use App\Http\Controllers\PM\Web\PM0022Controller;
use App\Http\Controllers\PM\Web\PM0023Controller;
use App\Http\Controllers\PM\Web\PM0024Controller;
use App\Http\Controllers\PM\Web\PM0025Controller;
use App\Http\Controllers\PM\Web\PM0026Controller;
use App\Http\Controllers\PM\Web\PM0027Controller;
use App\Http\Controllers\PM\Web\PM0028Controller;
use App\Http\Controllers\PM\Web\PM0029Controller;
use App\Http\Controllers\PM\Web\PM0030controller;
use App\Http\Controllers\PM\Web\PM0031Controller;
use App\Http\Controllers\PM\Web\PM0032Controller;
use App\Http\Controllers\PM\Web\PM0033Controller;
use App\Http\Controllers\PM\Web\PM0034Controller;
use App\Http\Controllers\PM\Web\PM0035Controller;
use App\Http\Controllers\PM\Web\PM0036Controller;
use App\Http\Controllers\PM\Web\PM0037Controller;
use App\Http\Controllers\PM\Web\PM0038Controller;
use App\Http\Controllers\PM\Web\PM0039Controller;
use App\Http\Controllers\PM\Web\PM0040Controller;
use App\Http\Controllers\PM\Web\PM0041Controller;
use App\Http\Controllers\PM\Web\PM0042Controller;
use App\Http\Controllers\PM\Web\PM0043Controller;
use App\Http\Controllers\PM\Web\PM0044Controller;
use App\Http\Controllers\PM\Web\PM0045Controller;
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

require base_path('routes/settings/_pm.php');

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
});

Route::get('test', function () {
    return 'ok';
});

//=== PM-0001 =================================================================
foreach (['0001', 'production-order'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0001Controller::class, 'index'])->name('index');
        Route::get('/{batch_no}', [PM0001Controller::class, 'index'])->name('show');
    });
}

//=== PM-0002 =================================================================
foreach (['0002', 'request-creation'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0002Controller::class, 'index'])->name('index');
    });
}

//=== PM-0003 =================================================================
foreach (['0003', 'annual-production-plan'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0003Controller::class, 'index'])->name('index');
    });
}

//=== PM-0004 =================================================================
foreach (['0004'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0004Controller::class, 'index'])->name('index');
    });
}

//=== PM-0005 =================================================================
foreach (['0005', 'request-materials'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{id?}', [PM0005Controller::class, 'index'])->name('index');
    });
}
foreach (['0005-2'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/{id?}', [PM0005_2Controller::class, 'index'])->name('index');
    });
}

//=== PM-0006 =================================================================
foreach (['0006', 'report-product-in-process'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0006Controller::class, 'index'])->name('index');
        Route::get('/jobs/{batchNo}', [PM0006Controller::class, 'showJob'])->name('jobs');
    });
}


//=== PM-0007 =================================================================
foreach (['0007', 'cut-raw-material'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0007Controller::class, 'index'])->name('index');
    });
}

//=== PM-0008 =================================================================
foreach (['0008', 'inventory-list'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0008Controller::class, 'index'])->name('index');
    });
}

//=== PM-0009 =================================================================
foreach (['0009', 'test-raw-material'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0009Controller::class, 'index'])->name('index');
    });
}

//=== PM-0010 =================================================================
foreach (['0010', 'review-complete'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0010Controller::class, 'index'])->name('index');
    });
}

//=== PM-0011 =================================================================
foreach (['0011', 'planning-job-lines'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('', [PM0011Controller::class, 'index'])->name('index');
    });
}

//=== PM-0012 =================================================================
foreach (['0012'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0012Controller::class, 'index'])->name('index');
    });
}

//=== PM-0013 =================================================================
foreach (['0013', 'record-tobacco-usage-zone-c48'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0013Controller::class, 'index'])->name('index');
    });
}

//=== PM-0013 =================================================================
foreach (['0014'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0014Controller::class, 'index'])->name('index');
    });
}

//=== PM-0015 =================================================================
foreach (['0015', 'regional-tobacco-production-planning'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0015Controller::class, 'index'])->name('index');
    });
}

//=== PM-0016 =================================================================
foreach (['0016'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0016Controller::class, 'index'])->name('index');
    });
}

//=== PM-0017 =================================================================
foreach (['0017', 'domestic-printing-production-planning'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0017Controller::class, 'index'])->name('index');
    });
}

//=== PM-0018 =================================================================
foreach (['0018', 'fortnightly-tobacco-production-order'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0018Controller::class, 'index'])->name('index');
    });
}

//=== PM-0019 =================================================================
foreach (['0019', 'fortnightly-raw-material-request'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('', [PM0019Controller::class, 'index'])->name('index');
    });
}

//=== PM-0020 =================================================================
foreach (['0020', 'machine-ingredient-requests'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0020Controller::class, 'index'])->name('index');
        Route::get('/{id}', [PM0020Controller::class, 'show'])->name('show');
    });
}

//=== PM-0021 =================================================================
foreach (['0021', 'ingredient-requests'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0021Controller::class, 'index'])->name('index');
    });
}

//=== PM-0022 =================================================================
foreach (['0022', 'ingredient-preparation-list'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0022Controller::class, 'index'])->name('index');
    });
}

//=== PM-0023 =================================================================
foreach (['0023', 'transaction-pnk-check-material'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0023Controller::class, 'index'])->name('index');
        Route::get('/rawMaterials/{id}', [PM0023Controller::class, 'showRawMaterial'])->name('rawMaterials');
        Route::get('/compareRawMaterials', [PM0023Controller::class, 'compareRequestAndOnShelfRawMaterial'])->name('compareRawMaterials');
    });
}

//=== PM-0024 =================================================================
foreach (['0024', 'transaction-pnk-material-transfer'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0024Controller::class, 'index'])->name('index');
    });
}

//=== PM-0025 =================================================================
foreach (['0025', 'confirm-orders'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0025Controller::class, 'index'])->name('index');
    });
}

//=== PM-0026 =================================================================
foreach (['0026', 'finished-products-storing-record'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0026Controller::class, 'index'])->name('index');
    });
}

//=== PM-0027 =================================================================
foreach (['0027', 'sample-cigarettes'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0027Controller::class, 'index'])->name('index');
        Route::get('/{date}', [PM0027Controller::class, 'show'])->name('show');
    });
}

//=== PM-0028 =================================================================
foreach (['0028', 'free-products'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0028Controller::class, 'index'])->name('index');
        Route::get('/{date}', [PM0028Controller::class, 'getProductByDate'])->name('date');
    });
}

//=== PM-0029 =================================================================
foreach (['0029', 'ingredient-inventory'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0029Controller::class, 'index'])->name('index');
    });
}

//=== PM-0030 =================================================================
foreach (['0030', 'confirm-production-yield-loss-for-tips'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0030controller::class, 'index'])->name('index');
    });
}

//=== PM-0031 =================================================================
foreach (['0031'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0031Controller::class, 'index'])->name('index');
    });
}

//=== PM-0032 =================================================================
foreach (['0032', 'stamp-using'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0032Controller::class, 'index'])->name('index');
        Route::get('/{stampHeaderId}', [PM0032Controller::class, 'show'])->name('show');
        Route::post('/', [PM0032Controller::class, 'create'])->name('create');
    });
}

//=== PM-0033 =================================================================
foreach (['0033', 'confirm-stamp-using'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0033Controller::class, 'index'])->name("index");
    });
}

//=== PM-0034 =================================================================
foreach (['0034', 'planning-produce-monthly'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0034Controller::class, 'index'])->name('index');
    });
}

//=== PM-0035 =================================================================
foreach (['0035', 'receive-raw-material-transfer-at-temporary-storage'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0035Controller::class, 'index'])->name('index');
    });
}

//=== PM-0036 =================================================================
foreach (['0036', 'close-product-order'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0036Controller::class, 'index'])->name("index");
    });
}

//=== PM-0037 =================================================================
foreach (['0037', 'raw-material-preparation'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0037Controller::class, 'index'])->name("index");
    });
}

//=== PM-0038 =================================================================
foreach (['0038', 'production-order-list'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0038Controller::class, 'index'])->name("index");
    });
}

//=== PM-0039 =================================================================
foreach (['0039', 'additive-inventory-alert'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0039Controller::class, 'index'])->name("index");
    });
}

//=== PM-0040 =================================================================
foreach (['0040', 'raw-material-inventory-alert'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0040Controller::class, 'index'])->name("index");
    });
}

//=== PM-0041 =================================================================
foreach (['0041', 'examine-casing-after-expiry-date'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0041Controller::class, 'index'])->name("index");
    });
}

//=== PM-0042 =================================================================
foreach (['0042', 'approval-casing-new-expiry-date'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0042Controller::class, 'index'])->name("index");
    });
}

//=== PM-0043 =================================================================
foreach (['0043' , 'transfer-finish-goods'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0043Controller::class, 'index'])->name("index");
    });
}

//=== PM-0044 =================================================================
foreach (['0044'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0044Controller::class, 'index'])->name("index");
    });
}
//=== PM-0045 =================================================================
foreach (['0045'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PM0045Controller::class, 'index'])->name("index");
    });
}


//=== Example =================================================================
foreach (['dbLookupExample'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [ExampleDbLookupController::class, 'index'])->name("index");
    });
}


Route::get('user', function () {
    return auth()->user();
});
