<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PM\Api\PM0027ApiController;

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
        Route::get('/', ['ExampleController', 'index'])->name("index");
    });
}
