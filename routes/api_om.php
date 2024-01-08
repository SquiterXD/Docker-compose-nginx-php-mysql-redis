<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OM\Api\ClaimController As ApiClaimController;
use App\Http\Controllers\OM\Api\TrackClaimController As ApiTrackClaimController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('claim/invoiceList', [ApiClaimController::class, 'invoiceList']);
Route::get('claim/detailList', [ApiClaimController::class, 'detailList']);
Route::post('claim/store', [ApiClaimController::class, 'store']);
Route::get('claim/getClaimNumbers', [ApiClaimController::class, 'getClaimNumbers']);

Route::get('track-claim/getHeaders', [ApiTrackClaimController::class, 'getHeaders']);
Route::get('track-claim/getSearch', [ApiTrackClaimController::class, 'getSearch']);
Route::get('track-claim/getCancleClaim', [ApiTrackClaimController::class, 'getCancleClaim']);
Route::get('track-claim/getConfirmReceipt', [ApiTrackClaimController::class, 'getConfirmReceipt']);
Route::get('track-claim/getConfirmCreditNote', [ApiTrackClaimController::class, 'getConfirmCreditNote']);
Route::get('track-claim/getImage', [ApiTrackClaimController::class, 'getImage']);
Route::get('track-claim/getConfirmCash', [ApiTrackClaimController::class, 'getConfirmCash']);


