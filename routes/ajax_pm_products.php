<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PM\Ajax\ProductMachineRequestController;
use App\Http\Controllers\PM\Ajax\ProductTransferController;
use App\Http\Controllers\PM\Ajax\ProductTransferSplitLotController;
use App\Http\Controllers\PM\Ajax\ProductTranController;

Route::get('/products/machine-requests/get-requests', [ProductMachineRequestController::class, 'getRequests'])->name('products.machine-requests.get-requests');
Route::get('/products/machine-requests/get-items', [ProductMachineRequestController::class, 'getItems'])->name('products.machine-requests.get-items');
Route::get('/products/machine-requests/get-item-machine-name', [ProductMachineRequestController::class, 'getItemMachineName'])->name('products.machine-requests.get-item-machine-name');
Route::get('/products/machine-requests/search-request-headers', [ProductMachineRequestController::class, 'searchRequestHeaders'])->name('products.machine-requests.search-request-headers');
Route::post('/products/machine-requests/generate-requests', [ProductMachineRequestController::class, 'generateRequests'])->name('products.machine-requests.generate-requests');
Route::post('/products/machine-requests/store-requests', [ProductMachineRequestController::class, 'storeRequests'])->name('products.machine-requests.store-requests');
Route::post('/products/machine-requests/export-pdf', [ProductMachineRequestController::class, 'exportPdf'])->name('products.machine-requests.export-pdf');

Route::prefix('/products/transfers')->name('products.transfers.')->group(function () {
    Route::get('find-header', [ProductTransferController::class, 'findHeader'])->name('find-header');
    Route::get('get-headers', [ProductTransferController::class, 'getHeaders'])->name('get-headers');
    Route::post('store-header', [ProductTransferController::class, 'storeHeader'])->name('store-header');
    Route::get('get-lines', [ProductTransferController::class, 'getLines'])->name('get-lines');
    Route::get('get-confirm-items', [ProductTransferController::class, 'getConfirmItems'])->name('get-confirm-items');
    Route::get('get-onhands', [ProductTransferController::class, 'getOnhands'])->name('get-onhands');
    Route::post('store-lines', [ProductTransferController::class, 'storeLines'])->name('store-lines');
    Route::post('confirm-request', [ProductTransferController::class, 'confirmRequest'])->name('confirm-request');
    Route::post('discard-confirmed-request', [ProductTransferController::class, 'discardConfirmedRequest'])->name('discard-confirmed-request');
    Route::post('cancel-request', [ProductTransferController::class, 'cancelRequest'])->name('cancel-request');
    Route::post('submit-request', [ProductTransferController::class, 'submitRequest'])->name('submit-request');
});

Route::prefix('/products/transfer-split-lots')->name('products.transfer-split-lots.')->group(function () {
    Route::get('find-header', [ProductTransferSplitLotController::class, 'findHeader'])->name('find-header');
    Route::get('get-headers', [ProductTransferSplitLotController::class, 'getHeaders'])->name('get-headers');
    Route::post('store-header', [ProductTransferSplitLotController::class, 'storeHeader'])->name('store-header');
    Route::get('get-lines', [ProductTransferSplitLotController::class, 'getLines'])->name('get-lines');
    Route::get('get-confirm-items', [ProductTransferSplitLotController::class, 'getConfirmItems'])->name('get-confirm-items');
    Route::get('get-onhands', [ProductTransferSplitLotController::class, 'getOnhands'])->name('get-onhands');
    Route::post('store-lines', [ProductTransferSplitLotController::class, 'storeLines'])->name('store-lines');
    Route::post('confirm-request', [ProductTransferSplitLotController::class, 'confirmRequest'])->name('confirm-request');
    Route::post('discard-confirmed-request', [ProductTransferSplitLotController::class, 'discardConfirmedRequest'])->name('discard-confirmed-request');
    Route::post('cancel-request', [ProductTransferSplitLotController::class, 'cancelRequest'])->name('cancel-request');
    Route::post('submit-request', [ProductTransferSplitLotController::class, 'submitRequest'])->name('submit-request');
});

Route::prefix('/products/trans')->name('products.trans.')->group(function () {
    Route::get('find-header', [ProductTranController::class, 'findHeader'])->name('find-header');
    Route::get('get-headers', [ProductTranController::class, 'getHeaders'])->name('get-headers');
    Route::post('store-header', [ProductTranController::class, 'storeHeader'])->name('store-header');
    Route::get('get-lines', [ProductTranController::class, 'getLines'])->name('get-lines');
    Route::get('get-confirm-items', [ProductTranController::class, 'getConfirmItems'])->name('get-confirm-items');
    Route::get('get-onhands', [ProductTranController::class, 'getOnhands'])->name('get-onhands');
    Route::post('store-lines', [ProductTranController::class, 'storeLines'])->name('store-lines');
    Route::post('confirm-request', [ProductTranController::class, 'confirmRequest'])->name('confirm-request');
    Route::post('discard-confirmed-request', [ProductTranController::class, 'discardConfirmedRequest'])->name('discard-confirmed-request');
    Route::post('cancel-request', [ProductTranController::class, 'cancelRequest'])->name('cancel-request');
    Route::post('submit-request', [ProductTranController::class, 'submitRequest'])->name('submit-request');
});