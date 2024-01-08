<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\PM\Api\QrcodeCheckMtlController as AjaxQrcodeCheckMtlController;
use App\Http\Controllers\Mobile\PM\QrcodeCheckMtlController;

use App\Http\Controllers\Mobile\PM\Api\QrcodeTransferMtlController as AjaxQrcodeTransferMtlController;
use App\Http\Controllers\Mobile\PM\QrcodeTransferMtlController;

use App\Http\Controllers\Mobile\PM\Api\QrcodeRcvTransferMtlController as AjaxQrcodeRcvTransferMtlController;
use App\Http\Controllers\Mobile\PM\QrcodeRcvTransferMtlController;

use App\Http\Controllers\Mobile\PM\Api\QrcodeReturnMtlController as AjaxQrcodeReturnMtlController;
use App\Http\Controllers\Mobile\PM\QrcodeReturnMtlController;




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
    Route::prefix('qrcode-check-mtls')->name('qrcode-check-mtls.')->group(function () {
        Route::get('detail', [AjaxQrcodeCheckMtlController::class, 'detail'])->name('detail');
    });

    Route::prefix('qrcode-transfer-mtls')->name('qrcode-transfer-mtls.')->group(function () {
        Route::get('detail', [AjaxQrcodeTransferMtlController::class, 'detail'])->name('detail');
    });

    Route::prefix('qrcode-rcv-transfer-mtls')->name('qrcode-rcv-transfer-mtls.')->group(function () {
        Route::get('detail', [AjaxQrcodeRcvTransferMtlController::class, 'detail'])->name('detail');
    });
    // PMP0043
    Route::prefix('qrcode-return-mtls')->name('qrcode-return-mtls.')->group(function () {
        Route::get('detail', [AjaxQrcodeReturnMtlController::class, 'detail'])->name('detail');
    });
});

// PMP0022
Route::prefix('qrcode-check-mtls')->name('qrcode-check-mtls.')->group(function () {
    Route::get('/', [QrcodeCheckMtlController::class, 'index'])->name('index');
});


// PMP0023
Route::prefix('qrcode-transfer-mtls')->name('qrcode-transfer-mtls.')->group(function () {
    Route::get('/', [QrcodeTransferMtlController::class, 'index'])->name('index');
});
// PMP0024
Route::prefix('qrcode-rcv-transfer-mtls')->name('qrcode-rcv-transfer-mtls.')->group(function () {
    Route::get('/', [QrcodeRcvTransferMtlController::class, 'index'])->name('index');
});
// PMP0043
Route::prefix('qrcode-return-mtls')->name('qrcode-return-mtls.')->group(function () {
    Route::get('/', [QrcodeReturnMtlController::class, 'index'])->name('index');
});