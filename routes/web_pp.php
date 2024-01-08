<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PP\Web\PP0001Controller;
use App\Http\Controllers\PP\Web\PP0002Controller;
use App\Http\Controllers\PP\Web\PP0003Controller;
use App\Http\Controllers\PP\Web\PP0004Controller;
use App\Http\Controllers\PP\Web\PP0005Controller;
use App\Http\Controllers\PP\Web\PP0006Controller;
use App\Http\Controllers\PP\Web\PP0007Controller;
use App\Http\Controllers\PP\Web\PP0008Controller;


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

//=== PM-0000 =================================================================
foreach (['0000', 'example'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [\App\Http\Controllers\PP\Web\PP0000Controller::class, 'index'])->name("index");
    });
}

//=== PM-0001 =================================================================
foreach (['0001'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0001Controller::class, 'index'])->name("index");
    });
}

//=== PM-0002 =================================================================
foreach (['0002'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0002Controller::class, 'index'])->name("index");
    });
}

//=== PM-0003 =================================================================
foreach (['0003'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0003Controller::class, 'index'])->name("index");
    });
}

//=== PM-0004 =================================================================
foreach (['0004'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0004Controller::class, 'index'])->name("index");
    });
}

//=== PM-0005 =================================================================
foreach (['0005'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0005Controller::class, 'index'])->name("index");
    });
}

//=== PM-0006 =================================================================
foreach (['0006'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0006Controller::class, 'index'])->name("index");
    });
}

//=== PM-0007 =================================================================
foreach (['0007'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0007Controller::class, 'index'])->name("index");
    });
}

//=== PM-0008 =================================================================
foreach (['0008'] as $routeBase) {
    Route::group(['as' => "{$routeBase}.", 'prefix' => $routeBase,], function () {
        Route::get('/', [PP0008Controller::class, 'index'])->name("index");
    });
}
