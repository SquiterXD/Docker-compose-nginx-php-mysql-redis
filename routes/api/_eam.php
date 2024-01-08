<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EamController;

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

// Route::get('/item-xxxx/department/{department}/budget-year/{budgetYear}/period/{periodNo}', [\EamController::class, 'itemImage'])
//     ->name('expense-dept');

Route::get('item/{itemId}/image', [EamController::class, 'itemImage'])->name('item-image');

// Route::get('item/{item-id}/image', function ($itemId) {

//     dd('ccc', $itemId);
//     return view('home.index');
//     return view('welcome');
// })->name('item-image');


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

