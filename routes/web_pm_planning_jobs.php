<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PM\PlanController;
use App\Http\Controllers\PM\Web\PlanningJobController;

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
Route::get('/planning-jobs', [PlanningJobController::class, 'index'])->name('planning-jobs.index');

