<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Ajax\RoleController as AjaxRoleController;
use App\Http\Controllers\Ajax\UserController as AjaxUserController;
use App\Http\Controllers\Auth\LoginController;
// use \Debugbar;

use App\Http\Controllers\Program\ProgramTypeController;
use App\Http\Controllers\Program\ProgramInfoController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\PD\Settings\ProgramColumnController;
// use App\Http\Controllers\PD\Settings\SimuRawMaterialController;

use App\Http\Controllers\RunningNumberController;
use App\Http\Controllers\Budget\InquiryFundsController;
use App\Http\Controllers\Budget\Ajax\InquiryFundsController as AjaxInquiryFundsController;

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


Route::get('phpinfo', function () {
    // phpinfo();
    // dd('xx', ini_get('post_max_size'));

    dd('xx', ini_get(request()->ini));
});

Route::get('cache-flush', function () {
    \Cache::flush();
    dd('cache-flush');
});

Route::get('carbon', function () {
    dd(\Carbon\Carbon::now());
});

Route::get('mail', function () {

    Mail::raw('Text to e-mail', function($message){
        $message->from('us@example.com', 'Laravel');
        $message->to('foo@example.com')->cc('bar@example.com')->subject('xxx: Move Order');
    });
    dd('x', env('MAIL_MAILER'));
});

// if (!env('APP_SHOW_DEBUGBAR', false)) {
//     \Debugbar::disable();
// }


// Route::namespace('Example')->prefix('example')->name('example.')->group(function () {
//     Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
//         Route::get('users', [UserController::class, 'index'])->name('users.index');
//     });
// });
Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('get-menu-by-module', [AjaxRoleController::class, 'getMenuByModule'])->name('get-menu-by-module');
        Route::get('get-permission', [AjaxRoleController::class, 'getPermission'])->name('get-permission');
        Route::post('/{role}/assign-permission', [AjaxRoleController::class, 'assignPermission'])->name('assign-permission');
    });

    Route::resource('roles', AjaxRoleController::class)->only(['store', 'update']);

    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/', [AjaxUserController::class, 'store'])->name('store');
        Route::patch('{user}', [AjaxUserController::class, 'update'])->name('update');
        Route::get('get-user', [AjaxUserController::class, 'getUser'])->name('get-user');
        Route::get('get-department', [AjaxUserController::class, 'getDepartment'])->name('get-department');
        Route::get('get-oa-user', [AjaxUserController::class, 'getOaUser'])->name('get-oa-user');
        Route::get('get-role', [AjaxUserController::class, 'getRole'])->name('get-role');
    });
});

Route::get('/test', function () {
    return view('notification-change-dept');
});

Route::post('/test/upload', function () {
    return 'Example Upload';
});

Route::get('test/aduser', [TestController::class, 'adUser']);
Route::get('test/aduser', [TestController::class, 'adUser']);

Route::get('test/aduser', [TestController::class, 'adUser']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home.index');
        return view('welcome');
    });
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::resource('menus', MenuController::class)->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);

    Route::get('users/sync-hr', [UserController::class, 'syncHr'])->name('users.syncHr');
    // update Department all User only -- Piyawut A. 20221103
    Route::get('users/sync-dept', [UserController::class, 'syncUpdateDept']);
    Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assign-permission');

    Route::get('users/{user}/change-deparment', [UserController::class, 'changeDeparment'])->name('users.change-deparment');
    Route::get('users/{user}/change-org', [UserController::class, 'changeOrg'])->name('users.change-org');
    Route::resource('users', UserController::class)->only(['index', 'create', 'edit']);
    Route::resource('roles', RoleController::class)->only(['index', 'create', 'edit']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Inquiry Fund
    Route::get('inquiry-funds', [InquiryFundsController::class, 'index'])->name('funds.index');
    Route::post('inquiry-funds', [AjaxInquiryFundsController::class, 'getInquriyFunds'])->name('funds.show');
    Route::get('ajax/inquiry-funds', [AjaxInquiryFundsController::class, 'index']);
    Route::get('ajax/inquiry-funds/transaction', [AjaxInquiryFundsController::class, 'getTransaction']);
    Route::post('ajax/inquiry-funds/period-balance', [AjaxInquiryFundsController::class, 'getPeriodBalance']);
    Route::post('ajax/inquiry-funds/period-year', [AjaxInquiryFundsController::class, 'getPeriodYear']);

    //Program
    Route::prefix('program')->name('program.')->group(function (){
        //type
        Route::get('/type', [ProgramTypeController::class, 'index'])->name('type.index');
        Route::get('/type/create', [ProgramTypeController::class, 'create'])->name('type.create');
        Route::post('/type', [ProgramTypeController::class, 'store'])->name('type.store');
        Route::get('/type/{program_type}/edit', [ProgramTypeController::class, 'edit'])->name('type.edit');
        Route::post('/type/update', [ProgramTypeController::class, 'update'])->name('type.update');
        //program
        Route::get('/info', [ProgramInfoController::class, 'index'])->name('info.index');
        Route::get('/info/create', [ProgramInfoController::class, 'create'])->name('info.create');
        Route::post('/info', [ProgramInfoController::class, 'store'])->name('info.store');
        Route::get('/info/{program_code}/edit', [ProgramInfoController::class, 'edit'])->name('info.edit');
        Route::post('/info/update', [ProgramInfoController::class, 'update'])->name('info.update');
    });

    Route::get('lookup', [LookupController::class, 'index'])->name('lookup.index');
    Route::get('lookup/create', [LookupController::class, 'create'])->name('lookup.create');
    Route::post('lookup', [LookupController::class, 'store'])->name('lookup.store');
    Route::get('lookup/{lookup}/edit', [LookupController::class, 'edit'])->name('lookup.edit');
    Route::put('lookup/{lookup}', [LookupController::class, 'update'])->name('lookup.update');
    Route::delete('lookup/{lookup}', [LookupController::class, 'destroy'])->name('lookup.delete');
    Route::get('lookup/search', [LookupController::class, 'search'])->name('lookup.search');
    Route::post('lookup/{program_code}', [LookupController::class, 'updateHeaderName'])->name('lookup.updateHeaderName');

    //set-up
    Route::get('set-up', [ProgramColumnController::class, 'index'])->name('set-up.index');
    Route::get('set-up/{program_code}/show', [ProgramColumnController::class, 'show'])->name('set-up.show');
    Route::post('set-up/{program_code}/{column_name}', [ProgramColumnController::class, 'update'])->name('set-up.update');

    // //PD Setting
    // Route::group(['namespace' => 'PD', 'prefix' => 'pd', 'as' => 'pd.'], function () {
    //     Route::group(['namespace' => 'Setting', 'prefix' => 'setting', 'as' => 'settings.'], function () {
    //         //กำหนดวัตถุดิบจำลอง
    //         Route::get('simu-raw-material', [SimuRawMaterialController::class, 'index'])->name('simu-raw-material.index');
    //         Route::get('simu-raw-material/create', [SimuRawMaterialController::class, 'create'])->name('simu-raw-material.create');
    //         Route::post('simu-raw-material', [SimuRawMaterialController::class, 'store'])->name('simu-raw-material.store');
    //         Route::get('simu-raw-material/{simu_raw_id}/edit', [SimuRawMaterialController::class, 'edit'])->name('simu-raw-material.edit');
    //         Route::put('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'update'])->name('simu-raw-material.update');
    //         Route::delete('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'destroy'])->name('simu-raw-material.delete');
    //         Route::get('simu-raw-material/{simu_raw_id}/create-inv', [SimuRawMaterialController::class, 'createInv'])->name('simu-raw-material.createInv');
    //     });
    // });


    // Route::get('running-number', [RunningNumberController::class, 'index'])->name('running-number.index');
    // Route::get('running-number/create', [RunningNumberController::class, 'create'])->name('running-number.create');

    Route::resource('running-number', RunningNumberController::class)->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);

});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes();
