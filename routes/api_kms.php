<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KmsController;
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

Route::get('/expense-all/type/{type}/budget-year/{budgetYear}/period/{periodNo}', [KmsController::class, 'expenseAll'])
    ->name('expense-all');

Route::get('/expense-dept/department/{department}/budget-year/{budgetYear}/period/{periodNo}', [KmsController::class, 'expenseDept'])
    ->name('expense-dept');

Route::get('/sum-exp-department/budget-year/{budgetYear}/period/{periodNo}', [KmsController::class, 'sumExpDepartment'])
    ->name('sum-exp-department');

Route::get('/sum-exp-all/budget-year/{budgetYear}/period/{periodNo}', [KmsController::class, 'sumExpAll'])
    ->name('sum-exp-all');

 Route::get('/ex-change-ratexxx', function () {

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
