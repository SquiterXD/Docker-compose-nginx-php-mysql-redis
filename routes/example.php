<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Example\Ajax\UserController as AjaxUserController;
use App\Http\Controllers\Example\UserController;


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
    Route::get('users', [AjaxUserController::class, 'index'])->name('users.index');
});


Route::prefix('users')->name('users.')->group(function () {
    Route::get('/export-excel', [UserController::class, 'exportExcel'])->name('export-excel');
    Route::get('/export-pdf', [UserController::class, 'exportPdf'])->name('export-pdf');
    Route::get('/{user}/interface', [UserController::class, 'interface'])->name('interface');
    Route::get('/interface-error', [UserController::class, 'interfaceError'])->name('interface-error');
});

Route::resource('users', UserController::class);
Route::get('vue', function () {
    return view('example.vue');
})->name('vue');



Route::get('date', function () {
    $user = \App\Models\User::first();

    $createDate = $user->creation_date;                                     // 02/02/2021
    $parseToDateTh = parseToDateTh('25/03/2021');                           // 25/03/2564
    $parseToDateTh2 = parseToDateTh($user->creation_date);                  // 02/02/2564
    $parseToDateTh3 = parseToDateTh($user->creation_date, 'H:i:s');         // 02/02/2564 14:23:31

    $parseFromDateTh = parseFromDateTh('25/03/2564');                       // 2021-03-25
    $parseFromDateTh2 = parseFromDateTh('25/03/2564 14:23:31', 'H:i:s');    // 2021-03-25 14:23:31

    return view('example.date');
})->name('date');

Route::get('interface', function () {

    $customerId = 145;
    $db     =   \DB::connection('oracle')->getPdo();
    $sql = "
            DECLARE
                lv_customer_number    VARCHAR2(100)   :=  NULL;
                lv_return_status      VARCHAR2(100)   :=  NULL;
                lv_return_msg         VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.GENERATE_CUSTOMER_NUMBER
                (
                      I_CUSTOMER_ID       =>  :customer_id
                    , I_MANUAL_PREFIX     =>  NULL
                    , O_CUSTOMER_NUMBER   =>  :lv_customer_number
                    , O_RETURN_STATUS     =>  :lv_return_status
                    , O_RETURN_MSG        =>  :lv_return_msg
                );
            END;
    ";

    $sql = preg_replace("/[\r\n]*/","",$sql);
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_STR);
    $stmt->bindParam(':lv_customer_number', $result['customer_number'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
    $stmt->execute();

    return $result;
})->name('date');


Route::get('interface2', function () {

    $shipToSiteId = 81;
    $db     =   \DB::connection('oracle')->getPdo();
    $sql = "
        DECLARE
            lv_return_status      VARCHAR2(100)   :=  NULL;
            lv_return_msg         VARCHAR2(4000)  :=  NULL;
        BEGIN
            PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER_SITE
            (
                I_SITE_ID         =>  :ship_to_site_id
              , o_return_status   =>  :lv_return_status
              , o_return_msg      =>  :lv_return_msg
            );
        END;
    ";

    $sql = preg_replace("/[\r\n]*/","",$sql);
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':ship_to_site_id', $shipToSiteId, \PDO::PARAM_STR);
    $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
    $stmt->execute();
    return $result;

})->name('date');

Route::get('date2', function () {
    return view('example.date2');
})->name('date2');
