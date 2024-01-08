<?php

use App\Http\Controllers\PD\Api\PD0001ApiController;
use App\Http\Controllers\PD\Api\PD0002ApiController;
use App\Http\Controllers\PD\Api\PD0004ApiController;
use App\Http\Controllers\PD\Api\PD0005ApiController;
use App\Http\Controllers\PD\Api\PD0006ApiController;
use App\Http\Controllers\PD\Api\PD0009ApiController;
use App\Http\Controllers\PD\Api\FlavorNoApiController;
use App\Http\Controllers\PM\Api\LookupController;
use App\Http\Controllers\PD\Api\InvMaterialItemApiController;
use App\Models\PD\PtpdInvMaterialItemHeader;
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


Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
});

Route::get('/lookup/{table}', [LookupController::class, 'lookupView'])->name('lookup');

//=== PD-0001 =================================================================
Route::get('0001/{id}', [PD0001ApiController::class, 'show']);
Route::post('0001', [PD0001ApiController::class, 'store']);
Route::put('0001/{id}', [PD0001ApiController::class, 'update']);
Route::delete('0001', [PD0001ApiController::class, 'remove_lines']);

//=== PD-0002 =================================================================
Route::get('0002/{id}', [PD0002ApiController::class, 'show']);
Route::post('0002', [PD0002ApiController::class, 'store']);
Route::put('0002/{id}', [PD0002ApiController::class, 'update']);
Route::delete('0002', [PD0002ApiController::class, 'remove_lines']);

//=== PM-0001 =================================================================
Route::group([
    'prefix' => 'flavor-no',
], function () {
    Route::get('/search', [FlavorNoApiController::class, 'search'])->name('flavor-no.search');
    Route::post('/store', [FlavorNoApiController::class, 'store'])->name('flavor-no.store');
    Route::put('/{id}/', [FlavorNoApiController::class, 'update'])->name('flavor-no.update');
    Route::get('/', [InvMaterialItemApiController::class, 'index']);
    Route::post('/', [InvMaterialItemApiController::class, 'create'])->name('inv-material-item.create');
    Route::put('/{id}', [InvMaterialItemApiController::class, 'update'])->name('inv-material-item.update');
    // Route::get('/{data}', [ExampleCigaretteApiController::class, 'search'])->name('inv-material-item.search');
    // Route::post('/', [ExampleCigaretteApiController::class, 'create'])->name('example-cigarettes.create');
    // Route::put('/{id}', [ExampleCigaretteApiController::class, 'update'])->name('example-cigarettes.update');
    // Route::delete('/{id}', [ExampleCigaretteApiController::class, 'delete'])->name('example-cigarettes.delete');
});


//=== PD-0004 =================================================================
foreach (['0004', 'inv-material-item'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::post('/', [PD0004ApiController::class, 'store'])->name('store');
        Route::get('/{inventoryItemId}', [PD0004ApiController::class, 'show'])->name('show');
        Route::put('/{rawMaterialId}', [PD0004ApiController::class, 'update'])->name('update');
    });
}

//=== PD-0005 =================================================================
foreach (['0005', 'example-cigarettes'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PD0005ApiController::class, 'search'])->name('search');
        Route::post('/', [PD0005ApiController::class, 'store'])->name('store');
        Route::get('/{inventoryItemCode}', [PD0005ApiController::class, 'show'])->name('show');
        Route::put('/{rawMaterialId}', [PD0005ApiController::class, 'update'])->name('update');
    });
}

//=== PD-0006 =================================================================
foreach (['0006', 'create-trial-tobacco-formula'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/blendFormulae', [PD0006ApiController::class, 'index'])->name('blendFormulae.index');
        Route::get('/blendFormulae/{blendId}', [PD0006ApiController::class, 'show'])->name('blendFormulae.show');
        Route::put('/blendFormulae/{blendId}', [PD0006ApiController::class, 'update'])->name('blendFormulae.update');

        Route::get('/mfgFormulae', [PD0006ApiController::class, 'getMfgFormulae'])->name('mfgFormulae.show');
        Route::get('/leafFormulae', [PD0006ApiController::class, 'getLeafFormulae'])->name('leafFormulae.show');

        Route::get('/lookupItemNumbers', [PD0006ApiController::class, 'lookupItemNumbers'])->name('lookupItemNumbers.show');
        Route::get('/lookupCasings', [PD0006ApiController::class, 'lookupCasings'])->name('lookupCasings.show');
        Route::get('/lookupFlavours', [PD0006ApiController::class, 'lookupFlavours'])->name('lookupFlavours.show');
        Route::get('/lookupExampleCigarettes', [PD0006ApiController::class, 'lookupExampleCigarettes'])->name('lookupExampleCigarettes.show');
    });
}


//=== PD-0009 =================================================================
Route::resource('expanded-tobacco', PD0009ApiController::class);
foreach (['0009'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/search', [PD0009ApiController::class, 'search'])->name('search');
    });
}

//=== TESTING =================================================================
Route::get('test', function () {
    return PtpdInvMaterialItemHeader::all();
});
