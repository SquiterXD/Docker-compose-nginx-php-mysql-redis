<?php

use Illuminate\Support\Facades\Route;






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



Route::group(['middleware' => ['guest.mobile']], function () {
    Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginFormMobile')->name("login");
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@loginMobile')->name("login.post");
});

Route::group(['middleware' => ['auth.mobile']], function () {
    Route::get('/', 'App\Http\Controllers\Mobile\HomeController@index')->name("index");
    Route::get('/change', 'App\Http\Controllers\Mobile\HomeController@change')->name("change");
    Route::get('users/{user}/change-org', 'App\Http\Controllers\Mobile\HomeController@changeOrg')->name("change-org");
    Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logoutMobile')->name("logout");
});