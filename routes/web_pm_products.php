<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PM\ProductMachineRequestController;
use App\Http\Controllers\PM\ProductTransferController;
use App\Http\Controllers\PM\ProductTranController;
use App\Http\Controllers\PM\ProductTransferSplitLotController;
use App\Http\Controllers\PM\FileController;

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


Route::get('/products/machine-requests', [ProductMachineRequestController::class, 'index'])->name('products.machine-requests.index');

Route::prefix('/products/transfers')->name('products.transfers.')->group(function () {
    Route::get('/', [ProductTransferController::class, 'index'])->name('index');
});

Route::prefix('/products/transfer-split-lots')->name('products.transfer-split-lots.')->group(function () {
    Route::get('/', [ProductTransferSplitLotController::class, 'index'])->name('index');
});

Route::prefix('/products/trans')->name('products.trans.')->group(function () {
    Route::get('/', [ProductTranController::class, 'index'])->name('index');
});

Route::get('/files/image/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'image'])->name('files.image');
Route::get('/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'imageThumbnail'])->name('files.image-thumbnail');
Route::get('/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}', [FileController::class, 'download'])->name('files.download');
