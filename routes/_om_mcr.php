<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OM\ApprovalClaimController;
use App\Http\Controllers\OM\Ajax\ApprovalClaimController As AjaxApprovalClaimController;
use App\Http\Controllers\OM\OutstandingController;
use App\Http\Controllers\OM\ImproveFineController;
use App\Http\Controllers\OM\Ajax\FineController;
use App\Http\Controllers\OM\ImproveFineExpController;

use App\Http\Controllers\OM\TaxAdjustmentsBKKController;
use App\Http\Controllers\OM\Ajax\TaxAdjustmentsBKKController As AjaxTaxAdjustmentsBKKController;
use App\Http\Controllers\OM\AttachmentController;

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
    Route::post('approval-claim/get-search', [AjaxApprovalClaimController::class, 'getSearch']);
    Route::post('approval-claim/update-approval-claim', [AjaxApprovalClaimController::class, 'updateApprovalClaim']);
    Route::post('approval-claim/update-replacement', [AjaxApprovalClaimController::class, 'updateReplacement']);
    // Route::post('approval-claim/update-RMA', [AjaxApprovalClaimController::class, 'updateRMA']);
    Route::post('approval-claim/closed-claim', [AjaxApprovalClaimController::class, 'closedClaim']);
    Route::get('approval-claim/report-claim', [AjaxApprovalClaimController::class, 'reportClaim']);

    Route::get('get-fine-list',    [FineController::class, 'getFineList']);
    
    Route::post('tax-adjustments-bkk/get-search', [AjaxTaxAdjustmentsBKKController::class, 'getSearch']);
    Route::post('tax-adjustments-bkk/store', [AjaxTaxAdjustmentsBKKController::class, 'store']);
    Route::get('get-invoice-list',    [FineController::class, 'getInvoiceList']);
    Route::get('get-customer-list',    [FineController::class, 'getCustomerList']);
});

// approval-claim 
Route::get('approval-claim', [ApprovalClaimController::class, 'index'])->name('approval-claim.index');

Route::get('outstanding', [OutstandingController::class, 'index'])->name('outstanding.index');
Route::get('outstanding-list', [OutstandingController::class, 'getData'])->name('outstanding.getData');
Route::get('outstanding-year', [OutstandingController::class, 'getYear'])->name('outstanding.getYear');

Route::get('improve-fine', [ImproveFineController::class, 'index'])->name('improve-fine.index');
Route::post('improve-fine', [ImproveFineController::class, 'store'])->name('improve-fine.store');

Route::get('tax-adjustments-bkk', [TaxAdjustmentsBKKController::class, 'index'])->name('tax-adjustments-bkk.index');

Route::prefix('attachments')->name('attachments.')->group(function () {
    Route::get('/{attachment}/image', [AttachmentController::class, 'image'])->name('image');
});
//OMP0071 ปรับปรุงค่าปรับยาสูบ สำหรับขายต่างประเทศ
Route::get('improve-fine-exp', [ImproveFineExpController::class, 'index'])->name('improve-fine-exp.index');
Route::post('improve-fine-exp', [ImproveFineExpController::class, 'store'])->name('improve-fine-exp.store');
