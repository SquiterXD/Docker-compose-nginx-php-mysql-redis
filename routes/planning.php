<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Planning\MachineYearlyController;
//PP02
use App\Http\Controllers\Planning\ProductionYearlyController;
use App\Http\Controllers\Planning\Ajax\ProductionYearlyController as AjaxProductionYearlyController;

use App\Http\Controllers\Planning\MachineBiWeeklyController;
use App\Http\Controllers\Planning\Ajax\MachineController as AjaxMachineController;

use App\Http\Controllers\Planning\Ajax\ProductionPlanController as AjaxProductionPlanController;

use App\Http\Controllers\Planning\ProductBiWeeklyController;
use App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController as AjaxProductBiWeeklyController;
// PP05
use App\Http\Controllers\Planning\AdjustController;
use App\Http\Controllers\Planning\Ajax\AdjustController as AjaxAdjustController;
// PP06
use App\Http\Controllers\Planning\FollowUpController;
use App\Http\Controllers\Planning\Ajax\FollowUpController as AjaxFollowUpController;
// PP08
use App\Http\Controllers\Planning\StampMonthlyController;
use App\Http\Controllers\Planning\Ajax\StampMonthlyController as AjaxStampMonthlyController;
// PP07
use App\Http\Controllers\Planning\ProductionDailyController;
use App\Http\Controllers\Planning\Ajax\ProductionDailyController as AjaxProductionDailyController;
// P09
use App\Http\Controllers\Planning\StampFollowController;
use App\Http\Controllers\Planning\Ajax\StampFollowController as AjaxStampFollowController;
// Setup
use App\Http\Controllers\Planning\Setup\PPS0011Controller;
use App\Http\Controllers\Planning\Setup\PPS0012Controller;
// PP10
use App\Http\Controllers\Planning\OverTimesPlanController;
use App\Http\Controllers\Planning\Ajax\OverTimesPlanController as AjaxOverTimesPlanController;
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

//Settings
require base_path('routes/settings/_planning.php');

Route::middleware(['auth'])->group(function () {
    // Planning
    // PPP0001
    Route::get('machine-yearly', [MachineYearlyController::class, 'index'])->name('machine-yearly.index');
    Route::post('machine-yearly', [MachineYearlyController::class, 'store'])->name('machine-yearly.store');
    Route::post('machine-yearly/{id}/update', [MachineYearlyController::class, 'update'])->name('machine-yearly.update');
    Route::post('machine-yearly/{machineHeader}/update-lines', [MachineYearlyController::class, 'updateLine'])->name('machine-yearly.update-lines');
    Route::post('machine-yearly/machine-detail', [MachineYearlyController::class, 'machineDetail'])->name('machine-yearly.machine-detail');
    Route::post('machine-yearly/update_plan_pm_yearly', [MachineYearlyController::class, 'UpdateEAMChangePm'])->name('machine-yearly.update_plan_pm_yearly');
    Route::post('machine-yearly/machine-downtime-yearly', [MachineYearlyController::class, 'machinedDowntime'])->name('machine-yearly.downtime');
    Route::post('machine-yearly/update-machine', [MachineYearlyController::class, 'updateMachine'])->name('machine-yearly.update-machine');
    Route::post('machine-yearly/get-sales-forecast-version/{id}', [MachineYearlyController::class, 'getSaleForecastVersion'])
        ->name('machine-yearly.sales-forecast-version');
    Route::post('machine-yearly/refresh-holiday', [MachineYearlyController::class, 'refreshHolidayUpdate'])->name('machine-yearly.refresh-holiday');
    Route::get('machine-yearly/pm-confirm/{machineHeader}', [MachineYearlyController::class, 'checkPmConfirm'])->name('machine-yearly.pm-confirm');
    Route::get('machine-yearly/check-machine-detail/{machineHeader}', [MachineYearlyController::class, 'checkMachineDetail'])
        ->name('machine-yearly.check-machine-detail');
    Route::post('machine-yearly/overview', [MachineYearlyController::class, 'storeOverview'])->name('machine-yearly.overview');


    // PPP0002
    Route::resource('production-yearly', ProductionYearlyController::class)->only(['index', 'show']);

    // PPP0003
    Route::get('machine-biweekly', [MachineBiWeeklyController::class, 'index'])->name('machine-biweekly.index');
    Route::post('machine-biweekly', [MachineBiWeeklyController::class, 'store'])->name('machine-biweekly.store');
    Route::post('machine-biweekly/{machineHeader}/update', [MachineBiWeeklyController::class, 'update'])->name('machine-biweekly.update');
    Route::post('machine-biweekly/{machineHeader}/update-lines', [MachineBiWeeklyController::class, 'updateLine'])->name('machine-biweekly.update-lines');
    Route::post('machine-biweekly/update_plan_pm_biweekly', [MachineBiWeeklyController::class, 'UpdateEAMChangePm'])
        ->name('machine-biweekly.update_plan_pm_biweekly');
    Route::post('machine-biweekly/machine-downtime-biweekly', [MachineBiWeeklyController::class, 'machinedDowntime'])->name('machine-biweekly.downtime');
    Route::post('machine-biweekly/update-machine/{id}', [MachineBiWeeklyController::class, 'updateMachine'])->name('machine-biweekly.update-machine');
    Route::post('machine-biweekly/get-sales-forecast-version/{id}', [MachineBiWeeklyController::class, 'getSaleForecastVersion'])
        ->name('machine-biweekly.sales_forecast_version');
    Route::post('machine-biweekly/refresh-holiday', [MachineBiWeeklyController::class, 'refreshHolidayUpdate'])->name('machine-biweekly.refresh-holiday');
    Route::get('machine-biweekly/pm-confirm/{machineHeader}', [MachineBiWeeklyController::class, 'checkPmConfirm'])->name('machine-biweekly.pm-confirm');
    Route::get('machine-biweekly/check-machine-detail/{machineHeader}', [MachineBiWeeklyController::class, 'checkMachineDetail'])
        ->name('machine-biweekly.check-machine-detail');

    // PPP0004
    Route::resource('production-biweekly', ProductBiWeeklyController::class)->only(['index', 'show']);
    // PPP0005
    Route::resource('adjusts', AdjustController::class)->only(['show', 'store']);
    // PPP0006
    Route::resource('follow-ups', FollowUpController::class)->only(['index']);
    Route::post('/follow-ups/export', [FollowUpController::class, 'ppr0004'])->name('follow-ups.ppr0004');
    // PPP0007
    Route::get('production-daily/{id}', [ProductionDailyController::class, 'show'])->name('production-daily.show');
    // PPP0008
    Route::resource('stamp-monthly', StampMonthlyController::class)->only(['index']);
    // PPP0009
    Route::get('stamp-follow', [StampFollowController::class, 'index'])->name('stamp-follow');
    Route::get('stamp-follow/{stampFollowMain}/export', [StampFollowController::class, 'exportFollowStamp'])->name('stamp-follow.export');

    //Setup PPS0011/PPS0012
    Route::prefix('setup')->name('setup.')->group(function () {
        Route::get('pps0011', [PPS0011Controller::class, 'index'])->name('pps0011.index');
        Route::get('pps0011/{item_id}/{formula_no}', [PPS0011Controller::class, 'show'])->name('pps0011.edit');
        Route::post('pps0011/{item_id}/{formula_no}/update', [PPS0011Controller::class, 'update'])->name('pps0011.update');
        // -----------------------------------
        Route::get('pps0012', [PPS0012Controller::class, 'index'])->name('pps0012.index');
        Route::get('pps0012/{day_code}', [PPS0012Controller::class, 'show'])->name('pps0012.edit');
        Route::post('pps0012/{day_code}/update', [PPS0012Controller::class, 'update'])->name('pps0012.update');
    });

    // PPP0010
    Route::prefix('overtimes-plan')->name('overtimes-plan.')->group(function () {
        Route::get('/', [OverTimesPlanController::class, 'index'])->name('index');
    });

    // Ajax
    Route::prefix('ajax')->name('ajax.')->group(function () {
        //machine
        Route::post('get-month-machine', [AjaxMachineController::class, 'findMonthMachine']);
        Route::post('get-biWeekly-machine', [AjaxMachineController::class, 'findBiWeeklyMachine']);

        Route::prefix('biWeekly')->name('biWeekly.')->group(function () {
            //plan
            Route::post('get-plan-machine', [AjaxProductionPlanController::class, 'getPlanMachine']);
            Route::get('get-est-data', [AjaxProductionPlanController::class, 'getEstData'])->name('prod.get-est-data');
            Route::get('get-avg-data', [AjaxProductionPlanController::class, 'getAvgData'])->name('prod.get-avg-data');
        });

        // PPP0002
        Route::prefix('production-yearly')->name('production-yearly.')->group(function () {
            Route::get('modal-create-details', [AjaxProductionYearlyController::class, 'modalCreateDetail'])->name('modal-create-details');
            Route::get('search', [AjaxProductionYearlyController::class, 'search'])->name('search');
            Route::post('/', [AjaxProductionYearlyController::class, 'store'])->name('store');
            // Update
            Route::patch('/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'update'])->name('update');
            // Approve
            Route::get('check-approve/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'checkApprove'])->name('check-approve');
            Route::patch('approve/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'approve'])->name('approve');
            // UnApprove
            Route::get('check-unapprove/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'checkUnapprove'])->name('check-unapprove');
            Route::patch('unapprove/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'unapprove'])->name('unapprove');
            // Copy Plan
            Route::patch('copy-plan/{productionBiweeklyMain}', [AjaxProductionYearlyController::class, 'copyPlan'])->name('copy-plan');
            //  tab1
            Route::get('get-plan-machine', [AjaxProductionYearlyController::class, 'getPlanMachine'])->name('get-plan-machine');
            // tab2
            // --2.1
            Route::get('get-summary-working-hour', [AjaxProductionYearlyController::class, 'getSummaryWorkingHour'])->name('get-summary-working-hour');
            // --2.2
            Route::get('get-est-by-brand', [AjaxProductionYearlyController::class, 'getEstimateByBrand'])->name('get-est-by-brand');
            // tab3
            Route::get('get-est-by-yearly', [AjaxProductionYearlyController::class, 'getEstimateByYearly'])->name('get-est-by-yearly');
            Route::post('update-status', [AjaxProductionYearlyController::class, 'updateHeaderStatus'])->name('update-status');
        });

        // PPP0004
        Route::prefix('production-biweekly')->name('production-biweekly.')->group(function () {
            Route::get('modal-create-details', [AjaxProductBiWeeklyController::class, 'modalCreateDetail'])->name('modal-create-details');
            Route::get('search', [AjaxProductBiWeeklyController::class, 'search'])->name('search');
            Route::post('/', [AjaxProductBiWeeklyController::class, 'store'])->name('store');
            Route::patch('/{productionBiweeklyMain}', [AjaxProductBiWeeklyController::class, 'update'])->name('update');
            Route::patch('approve/{productionBiweeklyMain}', [AjaxProductBiWeeklyController::class, 'approve'])->name('approve');
            Route::get('check-approve/{productionBiweeklyMain}', [AjaxProductBiWeeklyController::class, 'checkApprove'])->name('check-approve');
            // tab2.1
            Route::get('get-plan-machine', [AjaxProductBiWeeklyController::class, 'getPlanMachine'])->name('get-plan-machine');
            // tab2.2
            Route::get('get-est-data', [AjaxProductBiWeeklyController::class, 'getEstData'])->name('get-est-data');
            Route::get('get-avg-data', [AjaxProductBiWeeklyController::class, 'getAvgData'])->name('get-avg-data');
            // tab3
            Route::get('get-est-by-biweekly', [AjaxProductBiWeeklyController::class, 'getEstByBiweekly'])->name('get-est-by-biweekly');
        });

        // PPP0005
        Route::prefix('adjusts')->name('adjusts.')->group(function () {
            Route::get('search', [AjaxAdjustController::class, 'search'])->name('search');
            Route::get('search-create', [AjaxAdjustController::class, 'searchCreate'])->name('search-create');
            Route::get('search-item', [AjaxAdjustController::class, 'searchItem'])->name('search-item');
            Route::patch('/{productionBiweeklyMain}', [AjaxAdjustController::class, 'update'])->name('update');
            Route::patch('update-note/{id}', [AjaxAdjustController::class, 'updateNote'])->name('update-note');
            Route::get('get-adj-data', [AjaxAdjustController::class, 'getAdjData'])->name('get-adj-data');

            Route::patch('approve/{productionBiweeklyMain}', [AjaxAdjustController::class, 'approve'])->name('approve');
            Route::get('check-approve/{productionBiweeklyMain}', [AjaxAdjustController::class, 'checkApprove'])->name('check-approve');
        });

        // PPP0006
        Route::prefix('follow-ups')->name('follow-ups.')->group(function () {
            Route::get('search', [AjaxFollowUpController::class, 'search'])->name('search');
            Route::get('get-data', [AjaxFollowUpController::class, 'getData'])->name('get-data');
        });

        // PPP0007
        Route::prefix('production-daily')->name('production-daily.')->group(function () {
            Route::get('modal-create-details', [AjaxProductionDailyController::class, 'modalCreateDetail'])->name('modal-create-details');
            Route::get('search', [AjaxProductionDailyController::class, 'search'])->name('search');
            Route::get('create', [AjaxProductionDailyController::class, 'create'])->name('create');
            // Route::get('get-production-plan', [AjaxProductionDailyController::class, 'getProductionPlan'])->name('get-production-plan');
            Route::get('get-om-sales-forecast', [AjaxProductionDailyController::class, 'getOMSalesForecast'])->name('get-om-sales-forecast');
            Route::get('get-production-machine', [AjaxProductionDailyController::class, 'getProductionMachine'])->name('get-production-machine');
            Route::get('get-production-item', [AjaxProductionDailyController::class, 'getProductionItem'])->name('get-production-item');
            Route::post('machine', [AjaxProductionDailyController::class, 'submitChangeEfficiency'])->name('submit-production-machine');
            // Approve
            Route::get('check-approve/{machineBiweekly}/daily-plan/{dailyPlan}', [AjaxProductionDailyController::class, 'checkApprove'])->name('check-approve');
            Route::patch('approve/{dailyPlan}', [AjaxProductionDailyController::class, 'approve'])->name('approve');
            // UnApprove
            Route::get('check-unapprove/{machineBiweekly}/daily-plan/{dailyPlan}', [AjaxProductionDailyController::class, 'checkUnapprove'])->name('check-unapprove');
            Route::patch('unapprove/{dailyPlan}', [AjaxProductionDailyController::class, 'unapprove'])->name('unapprove');
            Route::get('get-grp-efficiency-product', [AjaxProductionDailyController::class, 'getGrpEfficiencyProduct'])->name('get-grp-efficiency-product');
            Route::get('update-working-hour/{res_plan_h_id}', [AjaxProductionDailyController::class, 'updateWorkingHour'])->name('update_working_hour');
            Route::get('check-working-hour', [AjaxProductionDailyController::class, 'checkEfficientcyP03P07'])->name('check_working_hour');
            // Route::get('get-prev-product', [AjaxProductionDailyController::class, 'getPrevProduct'])->name('get_prev_product');
        });

        // PPP0008
        Route::prefix('stamp-monthly')->name('stamp-monthly.')->group(function () {
            Route::get('modal-create-details', [AjaxStampMonthlyController::class, 'modalCreateDetail'])->name('modal-create-details');
            Route::get('get-est-data', [AjaxStampMonthlyController::class, 'getEstData'])->name('get-est-data');
            Route::post('/', [AjaxStampMonthlyController::class, 'store'])->name('store');
            Route::patch('/{ptppStampMonthly}', [AjaxStampMonthlyController::class, 'update'])->name('update');

            Route::any('/{ptppStampMonthly}/duplicate', [AjaxStampMonthlyController::class, 'duplicate'])->name('duplicate');
            Route::any('/{ptppStampMonthly}/update-est', [AjaxStampMonthlyController::class, 'updateEst'])->name('update-est');
            Route::get('search', [AjaxStampMonthlyController::class, 'search'])->name('search');

            Route::patch('approve/{stampMonthlyV}', [AjaxStampMonthlyController::class, 'approve'])->name('approve');
            Route::get('check-approve/{stampMonthlyV}', [AjaxStampMonthlyController::class, 'checkApprove'])->name('check-approve');
            Route::post('update-status', [AjaxStampMonthlyController::class, 'updateHeaderStatus'])->name('update_status');
        });

        // PPP0009
        Route::prefix('stamp-follow')->name('stamp-follow.')->group(function () {
            Route::get('/get-stamp-daily-tab1', [AjaxStampFollowController::class, 'getStampDailyTab1'])->name('get-stamp-daily-tab1');
            Route::get('/get-stamp-daily-tab2', [AjaxStampFollowController::class, 'getStampDailyTab2'])->name('get-stamp-daily-tab2');
            Route::post('/', [AjaxStampFollowController::class, 'store'])->name('store');
            Route::post('/validate_create', [AjaxStampFollowController::class, 'validateCreate'])->name('validate');
            Route::patch('/{stampFollowMain}', [AjaxStampFollowController::class, 'update'])->name('update');
            Route::get('update_issue/{stampFollowMain}', [AjaxStampFollowController::class, 'updateIssue'])->name('ajax-update-issue');
            Route::get('refresh_stamp/{stampFollowMain}', [AjaxStampFollowController::class, 'refreshStampTap1'])->name('ajax-refresh-stamp-tap1');
            Route::get('refresh_stamp_onhand/{stampFollowMain}', [AjaxStampFollowController::class, 'refreshStampOnhandTap2'])->name('ajax-refresh-stamp-onhand-tap2');
            // PR
            Route::get('get-period/{stampFollowMain}', [AjaxStampFollowController::class, 'getPeriod'])->name('ajax-get-period');
            Route::post('get-summary-interface-pr/{stampFollowMain}', [AjaxStampFollowController::class, 'getSummaryInterfacePR'])->name('ajax-get-summary-interface-pr');
            Route::post('interface-pr/{stampFollowMain}', [AjaxStampFollowController::class, 'interfacePR'])->name('ajax-interface-pr');
            Route::get('/get-stamp-daily-tab3', [AjaxStampFollowController::class, 'getStampDailyTab3'])->name('get-stamp-daily-tab3');
            Route::post('cancel-interface-pr/{stampFollowMain}', [AjaxStampFollowController::class, 'cancelInterfacePR'])->name('ajax-cancel-interface-pr');
            Route::get('print-report-pr/{stampFollowMain}', [AjaxStampFollowController::class, 'printCTReportPR'])->name('ajax-print-report-pr');
        });

        // PPP0010
        Route::prefix('overtimes-plan')->name('overtimes-plan.')->group(function () {
            Route::post('create-ot-plan', [AjaxOverTimesPlanController::class, 'createOTPlan'])->name('create-ot-plan');
            Route::post('get-ot-plan/{otMain}', [AjaxOverTimesPlanController::class, 'getOTPlan'])->name('get-ot-plan');
            Route::post('update-ot-plan/{otMain}', [AjaxOverTimesPlanController::class, 'updateOTPlan'])->name('update-ot-plan');
            Route::post('update-ot-percent/{otMain}', [AjaxOverTimesPlanController::class, 'updateOTPercent'])->name('update-ot-percent');
            Route::post('budget-ot-plan/{otMain}', [AjaxOverTimesPlanController::class, 'budgetOtPlan'])->name('budget-ot-plan');
            Route::get('report-ot-plan/{otMain}', [AjaxOverTimesPlanController::class, 'reportOtPlan'])->name('report-ot-plan');
        });
    });
});
