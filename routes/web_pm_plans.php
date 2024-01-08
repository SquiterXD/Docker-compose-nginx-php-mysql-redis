<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\PM\PlanController;
use App\Http\Controllers\PM\PlanYearlyController;
use App\Http\Controllers\PM\PlanMonthlyController;
use App\Http\Controllers\PM\PlanBiweeklyController;
use App\Http\Controllers\PM\PlanDailyController;
use App\Http\Controllers\PM\PlanApprovalYearlyController;
use App\Http\Controllers\PM\PlanApprovalBiweeklyController;
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


Route::get('/plans/yearly', [PlanYearlyController::class, 'index'])->name('plans.yearly');
Route::get('/plans/monthly', [PlanMonthlyController::class, 'index'])->name('plans.monthly');
Route::get('/plans/biweekly', [PlanBiweeklyController::class, 'index'])->name('plans.biweekly');
Route::get('/plans/daily', [PlanDailyController::class, 'index'])->name('plans.daily');

Route::get('/plans/approvals/yearly', [PlanApprovalYearlyController::class, 'index'])->name('plans.approvals.yearly');
Route::get('/plans/approvals/biweekly', [PlanApprovalBiweeklyController::class, 'index'])->name('plans.approvals.biweekly');