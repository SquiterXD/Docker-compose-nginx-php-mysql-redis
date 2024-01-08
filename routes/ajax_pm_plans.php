<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\PM\Ajax\PlanController;
use App\Http\Controllers\PM\Ajax\PlanYearlyController;
use App\Http\Controllers\PM\Ajax\PlanMonthlyController;
use App\Http\Controllers\PM\Ajax\PlanBiweeklyController;
use App\Http\Controllers\PM\Ajax\PlanDailyController;

Route::get('/plans/yearly/get-info', [PlanYearlyController::class, 'getInfo'])->name('plans.yearly.get-info');
Route::get('/plans/yearly/get-source-versions', [PlanYearlyController::class, 'getSourceVersions'])->name('plans.yearly.get-source-versions');
Route::post('/plans/yearly/add-new-header', [PlanYearlyController::class, 'addNewHeader'])->name('plans.yearly.add-new-header');
Route::post('/plans/yearly/update-source-version', [PlanYearlyController::class, 'updateSourceVersion'])->name('plans.yearly.update-source-version');
Route::get('/plans/yearly/get-sale-plans', [PlanYearlyController::class, 'getSalePlans'])->name('plans.yearly.get-sale-plans');
Route::get('/plans/yearly/get-lines', [PlanYearlyController::class, 'getLines'])->name('plans.yearly.get-lines');
Route::post('/plans/yearly/generate-lines', [PlanYearlyController::class, 'generateLines'])->name('plans.yearly.generate-lines');
Route::post('/plans/yearly/store-lines', [PlanYearlyController::class, 'storeLines'])->name('plans.yearly.store-lines');
Route::post('/plans/yearly/submit-approval', [PlanYearlyController::class, 'submitApproval'])->name('plans.yearly.submit-approval');
Route::post('/plans/yearly/submit-plan', [PlanYearlyController::class, 'submitPlan'])->name('plans.yearly.submit-plan');
Route::post('/plans/yearly/approve', [PlanYearlyController::class, 'approve'])->name('plans.yearly.approve');
Route::post('/plans/yearly/reject', [PlanYearlyController::class, 'reject'])->name('plans.yearly.reject');

Route::get('/plans/monthly/get-info', [PlanMonthlyController::class, 'getInfo'])->name('plans.monthly.get-info');
Route::get('/plans/monthly/get-source-versions', [PlanMonthlyController::class, 'getSourceVersions'])->name('plans.monthly.get-source-versions');
Route::post('/plans/monthly/add-new-header', [PlanMonthlyController::class, 'addNewHeader'])->name('plans.monthly.add-new-header');
Route::get('/plans/monthly/get-months', [PlanMonthlyController::class, 'getMonths'])->name('plans.monthly.get-months');
Route::get('/plans/monthly/get-sale-plans', [PlanMonthlyController::class, 'getSalePlans'])->name('plans.monthly.get-sale-plans');
Route::get('/plans/monthly/get-lines', [PlanMonthlyController::class, 'getLines'])->name('plans.monthly.get-lines');
Route::get('/plans/monthly/get-remaining-date-txt', [PlanMonthlyController::class, 'getRemainingDateTxt'])->name('plans.monthly.get-remaining-date-txt');
Route::get('/plans/monthly/get-sales-forecasts', [PlanMonthlyController::class, 'getSalesForecasts'])->name('plans.monthly.get-sales-forecasts');
Route::post('/plans/monthly/generate-lines', [PlanMonthlyController::class, 'generateLines'])->name('plans.monthly.generate-lines');
Route::post('/plans/monthly/store-lines', [PlanMonthlyController::class, 'storeLines'])->name('plans.monthly.store-lines');
Route::post('/plans/monthly/submit-plan', [PlanMonthlyController::class, 'submitPlan'])->name('plans.monthly.submit-plan');

Route::get('/plans/biweekly/get-info', [PlanBiweeklyController::class, 'getInfo'])->name('plans.biweekly.get-info');
Route::get('/plans/biweekly/get-source-versions', [PlanBiweeklyController::class, 'getSourceVersions'])->name('plans.biweekly.get-source-versions');
Route::post('/plans/biweekly/add-new-header', [PlanBiweeklyController::class, 'addNewHeader'])->name('plans.biweekly.add-new-header');
Route::get('/plans/biweekly/get-months', [PlanBiweeklyController::class, 'getMonths'])->name('plans.biweekly.get-months');
Route::get('/plans/biweekly/get-biweeks', [PlanBiweeklyController::class, 'getBiweeks'])->name('plans.biweekly.get-biweeks');
Route::get('/plans/biweekly/get-lines', [PlanBiweeklyController::class, 'getLines'])->name('plans.biweekly.get-lines');
Route::post('/plans/biweekly/generate-lines', [PlanBiweeklyController::class, 'generateLines'])->name('plans.biweekly.generate-lines');
Route::post('/plans/biweekly/store-lines', [PlanBiweeklyController::class, 'storeLines'])->name('plans.biweekly.store-lines');
Route::post('/plans/biweekly/submit-approval', [PlanBiweeklyController::class, 'submitApproval'])->name('plans.biweekly.submit-approval');
Route::post('/plans/biweekly/submit-open-order', [PlanBiweeklyController::class, 'submitOpenOrder'])->name('plans.biweekly.submit-open-order');
Route::post('/plans/biweekly/approve', [PlanBiweeklyController::class, 'approve'])->name('plans.biweekly.approve');
Route::post('/plans/biweekly/reject', [PlanBiweeklyController::class, 'reject'])->name('plans.biweekly.reject');

Route::get('/plans/daily/get-info', [PlanDailyController::class, 'getInfo'])->name('plans.daily.get-info');
Route::get('/plans/daily/get-source-versions', [PlanDailyController::class, 'getSourceVersions'])->name('plans.daily.get-source-versions');
Route::post('/plans/daily/add-new-header', [PlanDailyController::class, 'addNewHeader'])->name('plans.daily.add-new-header');
Route::get('/plans/daily/get-months', [PlanDailyController::class, 'getMonths'])->name('plans.daily.get-months');
Route::get('/plans/daily/get-biweeks', [PlanDailyController::class, 'getBiweeks'])->name('plans.daily.get-biweeks');
Route::get('/plans/daily/get-weeks', [PlanDailyController::class, 'getWeeks'])->name('plans.daily.get-weeks');
Route::get('/plans/daily/get-lines', [PlanDailyController::class, 'getLines'])->name('plans.daily.get-lines');
Route::get('/plans/daily/get-product-plans', [PlanDailyController::class, 'getProductPlans'])->name('plans.daily.get-product-plans');
Route::post('/plans/daily/generate-lines', [PlanDailyController::class, 'generateLines'])->name('plans.daily.generate-lines');
Route::get('/plans/daily/get-remaining-items', [PlanDailyController::class, 'getRemainingItems'])->name('plans.daily.get-remaining-items');
Route::post('/plans/daily/store-line', [PlanDailyController::class, 'storeLine'])->name('plans.daily.store-line');
Route::post('/plans/daily/add-new-machine-line', [PlanDailyController::class, 'addNewMachineLine'])->name('plans.daily.add-new-machine-line');
Route::post('/plans/daily/add-new-line', [PlanDailyController::class, 'addNewLine'])->name('plans.daily.add-new-line');
Route::post('/plans/daily/delete-machine-line', [PlanDailyController::class, 'deleteMachineLine'])->name('plans.daily.delete-machine-line');
Route::post('/plans/daily/delete-line', [PlanDailyController::class, 'deleteLine'])->name('plans.daily.delete-line');
// Route::post('/plans/daily/store-lines', [PlanDailyController::class, 'storeLines'])->name('plans.daily.store-lines');
Route::post('/plans/daily/submit-plan', [PlanDailyController::class, 'submitPlan'])->name('plans.daily.submit-plan');