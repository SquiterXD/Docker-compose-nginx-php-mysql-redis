<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PM\RequestMaterialController;
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
    
    Route::post('request-raw-materials', [RequestMaterialController::class, 'store'])->name('store');
    Route::put('request-raw-materials/{id}', [RequestMaterialController::class, 'update'])->name('update');
    Route::post('get-list-item-conv-uomv', [RequestMaterialController::class, 'getListItemConvUomV'])->name('getListItemConvUomV');

});


Route::prefix('request-raw-materials')->name('request-raw-materials.')->group(function () {

    Route::get('/', [RequestMaterialController::class, 'index']);
    
});
