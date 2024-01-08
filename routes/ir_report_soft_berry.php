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
// Route::middleware(['web', 'auth'])->group(function () {

// });

// Route::middleware(['auth.api'])->prefix('api')->name('api.')->group(function () {

// });


Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {

});


Route::prefix('ir-report')->name('ir-report.')->group(function () {

});



