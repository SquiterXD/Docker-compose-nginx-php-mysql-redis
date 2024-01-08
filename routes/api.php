<?php

use App\Http\Controllers\DbLookupController;
use App\Http\Controllers\OM\Api\AdditionQuotaController;
use App\Http\Controllers\OM\Api\CountryController;
use App\Http\Controllers\OM\Api\CurrencyController;
use App\Http\Controllers\OM\Api\CustomerApprovalsController;
use App\Http\Controllers\OM\Api\CustomerController;
use App\Http\Controllers\OM\Api\CustomerOwnerController;
use App\Http\Controllers\OM\Api\CustomerTypeExportController;
use App\Http\Controllers\OM\Api\FormOrderHeaderController;
use App\Http\Controllers\OM\Api\PostponeController;
use App\Http\Controllers\OM\Api\TerritoryVController;
use App\Http\Controllers\OM\Api\ProductTypeExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OM\Api\OrderEcomController;
use App\Http\Controllers\OM\Api\OrderExportEcomController;
use App\Http\Controllers\OM\Api\OrderTrackingController;
use App\Http\Controllers\OM\Api\ApproveSaleConfirmationController;
use App\Http\Controllers\OM\Api\AttachmentController;

use App\Http\Controllers\OM\Api\OutstandingController;
use App\Http\Controllers\OM\Api\OverdueDebtApiController;
use App\Http\Controllers\OM\Api\OverdueDebtController;

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

Route::get('/lookup', [DbLookupController::class, 'lookup'])->name('api.db.lookup');

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'country'], function () {
        Route::get('/', [CountryController::class, 'index']);
    });

    Route::group(['prefix' => 'currency'], function () {
        Route::get('/', [CurrencyController::class, 'index']);
    });

    Route::group(['prefix' => 'customer-type'], function () {
        Route::get('/domestic', [CustomerController::class, 'byTypeDomestic']);
        Route::get('/export', [CustomerTypeExportController::class, 'index']);
        Route::get('/export/type/{id}', [CustomerTypeExportController::class, 'byTypeId']);
    });

    Route::group(['prefix' => 'product-type'], function () {
        Route::get('/export', [ProductTypeExportController::class, 'index']);
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/by/id/{id}', [CustomerController::class, 'byId']);
        Route::get('/by/customer-number/{number}', [CustomerController::class, 'byCustomerNumber']);
        Route::post('/send/approval', [CustomerController::class, 'update']);
        Route::post('/send-mail-forgot', [CustomerController::class, 'send_mail_forgot']);
        Route::post('/send-mail-active', [CustomerController::class, 'send_mail_active']);
        Route::get('/approvals/type/{id}', [CustomerApprovalsController::class, 'byCustomerType']);
        Route::get('/approvals/type-export', [CustomerApprovalsController::class, 'byCustomerTypeExport']);
        Route::get('/approvals/first', [CustomerApprovalsController::class, 'byCustomerTypeFirst']);
        Route::get('/prefix-name', [CustomerController::class, 'prefix']);
        Route::get('/gen-req-number', [CustomerController::class, 'genReqNumber']);
    });

    Route::group(['prefix' => 'territory'], function () {
        Route::get('/province', [TerritoryVController::class, 'province']);
        Route::get('/district/{province_id}', [TerritoryVController::class, 'district']);
        Route::get('/tambon/{district_id}', [TerritoryVController::class, 'tambon']);
        Route::get('/postcode/{tambon_id}', [TerritoryVController::class, 'postcode']);
    });

    Route::group(['prefix' => 'postpone'], function () {
        Route::get('/create', [PostponeController::class, 'create']);
        Route::post('/search', [PostponeController::class, 'search']);
        Route::post('/store', [PostponeController::class, 'store']);
        Route::post('/update/{id}', [PostponeController::class, 'update']);
        Route::post('/search/by/id', [PostponeController::class, 'searchById']);
        Route::post('/update_remark', [PostponeController::class, 'update_remark']);
        Route::post('/default-post-pone', [PostponeController::class, 'defaultPostPone']);
    });

    Route::prefix('form-order')->group(function () {
        Route::get('/search/item/{keyword}', [FormOrderHeaderController::class, 'search']);
        Route::post('/follow', [FormOrderHeaderController::class, 'follow']);
        Route::post('/request', [FormOrderHeaderController::class, 'request']);
        Route::post('/requests', [FormOrderHeaderController::class, 'requests']);
        Route::post('/store', [FormOrderHeaderController::class, 'store']);
        Route::post('/getInfo', [FormOrderHeaderController::class, 'getInfo']);
        Route::post('/getInfoS', [FormOrderHeaderController::class, 'getInfoS']);
        Route::post('/approve', [FormOrderHeaderController::class, 'approve']);
        Route::get('/report/{id}', [FormOrderHeaderController::class, 'report']);
        Route::post('/approveS', [FormOrderHeaderController::class, 'approveS']);
        Route::post('/savebefore/approveS', [FormOrderHeaderController::class, 'savebeforeapproveS']);
        Route::post('/getlastorder', [FormOrderHeaderController::class, 'lastorder']);
        Route::post('/getlastorderdate', [FormOrderHeaderController::class, 'lastOrderDate']);
        Route::post('/attribute1', [FormOrderHeaderController::class, 'attribute1']);
    });

    Route::prefix('addition-quota')->group(function () {
        Route::post('/request', [AdditionQuotaController::class, 'request']);
        Route::post('/store', [AdditionQuotaController::class, 'store']);
    });
    Route::group(['prefix' => 'orders'], function () {

        Route::get('/convertCGK', [OrderEcomController::class, 'convertCGK']);

        Route::get('/customer-domestic', [OrderEcomController::class, 'customerDomestic']);
        Route::get('/customer-selected-payment/{customer_id}', [OrderEcomController::class, 'customerSelectedPaymentType']);

        Route::get('/product-domestic', [OrderEcomController::class, 'productTypeDomestic']);
        Route::get('/payment-type', [OrderEcomController::class, 'paymentType']);
        Route::get('/payment-method-domestic', [OrderEcomController::class, 'paymentMethodDomestic']);
        Route::get('/payment-method-lookup/{id}', [OrderEcomController::class, 'paymentMethodDomesticById']);
        Route::get('/payment-method-domestic/{number}', [OrderEcomController::class, 'paymentMethodDomesticByCustomer']);
        Route::get('/payment-method-export', [OrderEcomController::class, 'paymentMethodExport']);
        Route::get('/shipment-by', [OrderEcomController::class, 'shipmentBy']);
        Route::get('/shipment-by-domestic', [OrderEcomController::class, 'shipmentByDomestic']);
        Route::get('/installment', [OrderEcomController::class, 'installment']);
        Route::get('/special-case/{customer_id}', [OrderEcomController::class, 'specialCase']);
        Route::get('/special-case2/{customer_id}', [OrderEcomController::class, 'specialCase2']);
        Route::get('/by-number/{number}', [OrderEcomController::class, 'orderByNumber']);
        Route::get('/purchase/by-number/{number}', [OrderEcomController::class, 'orderPurchaseByNumber']);
        Route::get('/by-special-number/{number}', [OrderEcomController::class, 'orderSpecialByNumber']);
        Route::get('/check-expire-book/{id}', [OrderEcomController::class, 'checkExpireBook']);
        Route::get('/bank/{number}', [OrderEcomController::class, 'bankById']);
        Route::get('/bank-customer/{customer_id}/{bank_type}', [OrderEcomController::class, 'bankByCustomer']);

        Route::get('/period/{number}/{product_type}', [OrderEcomController::class, 'orderPeriod']);
        Route::get('/period-by-line/{id}', [OrderEcomController::class, 'orderPeriodByLineId']);

        Route::post('/checkDate', [OrderEcomController::class, 'checkDate']);

        Route::post('/store', [OrderEcomController::class, 'store']);
        Route::post('/update', [OrderEcomController::class, 'update']);
        Route::post('/update-special', [OrderEcomController::class, 'updateSpecial']);
        Route::post('/checkOver', [OrderEcomController::class, 'checkOver']);
        Route::post('/addOver', [OrderEcomController::class, 'addOver']);
        Route::post('/update-purchase', [OrderEcomController::class, 'updatePurchase']);
        Route::post('/cancel', [OrderEcomController::class, 'cancel']);
        Route::post('/uploads-file/{id}', [OrderEcomController::class, 'uploadFile']);

        Route::post('/check-promotion', [OrderEcomController::class, 'checkPromotion']);
        Route::get('/test-insert', [OrderEcomController::class, 'test_insert']);

        Route::get('/data-customer/{id}', [OrderEcomController::class, 'orderDataCustomer']);

        Route::get('remove-order/{id}', [OrderEcomController::class, 'removeOrder']);
    });

    Route::group(['prefix' => 'orders-export'], function () {
        Route::get('/gen-number', [OrderExportEcomController::class, 'genNumber']);
        Route::get('/customer-export', [OrderExportEcomController::class, 'customerExport']);
        Route::get('/product-export', [OrderExportEcomController::class, 'productTypeExport']);
        Route::get('/payment-type', [OrderExportEcomController::class, 'paymentType']);
        Route::get('/payment-method-export', [OrderExportEcomController::class, 'paymentMethodExport']);
        Route::get('/shipment-by-export', [OrderExportEcomController::class, 'shipmentByExport']);
        Route::get('/purchase/by-number/{number}', [OrderExportEcomController::class, 'orderPurchaseByNumber']);

        Route::post('/cancel', [OrderExportEcomController::class, 'cancel']);

        Route::post('/store', [OrderExportEcomController::class, 'store']);
        Route::post('/update', [OrderExportEcomController::class, 'update']);
        Route::get('/data-customer/{id}', [OrderExportEcomController::class, 'orderDataCustomer']);
    });

    Route::group(['prefix' => 'orders-tracking'], function () {

        Route::get('/search/{number}', [OrderTrackingController::class, 'search']);
        Route::post('/search-export/{number}', [OrderTrackingController::class, 'searchExport']);
        Route::post('/search-domestic/{number}', [OrderTrackingController::class, 'searchDomestic']);

        Route::post('/history/{number}/{type}', [OrderTrackingController::class, 'history']);
        Route::get('/customer-order-number/{number}', [OrderTrackingController::class, 'poNumberByCustomer']);
    });


    Route::prefix('approve-sale-confirmation')->group(function () {
        Route::post('/', [ApproveSaleConfirmationController::class, 'index']);
        Route::post('/update', [ApproveSaleConfirmationController::class, 'update']);
        Route::post('/attachment', [ApproveSaleConfirmationController::class, 'uploadAttachment']);
        Route::post('/remove_attachment', [ApproveSaleConfirmationController::class, 'removeAttachment']);
    });

    Route::prefix('customer-owner')->group(function () {
        Route::get('/by/id/{id}', [CustomerOwnerController::class, 'byId']);
        Route::get('/by/customer/{id}', [CustomerOwnerController::class, 'byCustomerId']);
    });

    Route::post('upload-attachment-multiple', [AttachmentController::class, 'uploadAttachmentMultiple']);
    Route::post('remove-attachment', [AttachmentController::class, 'removeAttachmentFile']);
});

Route::get('/ex-change-rate', function () {
    try {
        $date = now()->format('Y-m-d');
        $fromCurrencyCode = 'THB';
        $toCurrencyCode = strtoupper(request()->to_currency_code);
        if (request()->date) {
            $date = \Carbon\Carbon::parse(request()->date)->format('Y-m-d');
        }

        if (!$toCurrencyCode) {
            throw new \Exception("ไม่พบค่า to_currency_code");
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://apigw1.bot.or.th/bot/public/Stat-ExchangeRate/v2/DAILY_AVG_EXG_RATE/?start_period={$date}&end_period={$date}&currency={$toCurrencyCode}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "x-ibm-client-id: 21dc8bd6-b141-413e-bc60-6cadf7b730e7"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception($err);
        } else {
            $res = json_decode($response);
            $data = $res;
        }

        $data = [
            'status' => 'S',
            'date' => $date,
            'to_currency_code' => $toCurrencyCode,
            'data' => $data
        ];

    } catch (\Exception $e) {
        \Log::error($e);
        $data = [
            'status' => 'E',
            'msg' => $e->getMessage()
        ];
    }

    return response()->json(['data' => $data]);
});
Route::get('outstanding-test', [OutstandingController::class, 'index'])->name('outstanding-test.index');

Route::post('overdue-debt/search', [OverdueDebtApiController::class, 'search']);
