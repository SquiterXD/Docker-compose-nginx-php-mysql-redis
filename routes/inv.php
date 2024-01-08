<?php

use App\Http\Controllers\INV\Ajax\PtinvIssueReturnsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\INV\DisbursementFuelController;
use App\Http\Controllers\INV\IssueApproveDetailController;
use App\Http\Controllers\INV\IssueReturnController;
use App\Http\Controllers\INV\RequisitionStationeryController;
use App\Http\Controllers\INV\WebFuelReportController;
use App\Http\Controllers\INV\WebStationeryReportController;

Route::get('requisition_stationery/summary-web-stationery-pdf', [WebStationeryReportController::class, 'createSummaryWebStationeryPDF'])
    ->name('requisition_stationery.summary-web-stationery-pdf');
Route::get('requisition_stationery/order-history-pdf', [WebStationeryReportController::class, 'createOrderHistoryPDF'])
    ->name('requisition_stationery.order-history-pdf');
Route::get('requisition_stationery/{id}/ct-web-stationery-pdf', [WebStationeryReportController::class, 'createCtWebStationeryPDF'])
    ->name('requisition_stationery.ct-web-stationery-pdf');
Route::get('requisition_stationery/summary-web-stationery-report', [WebStationeryReportController::class, 'summaryWebStationeryReport'])
    ->name('requisition_stationery.summary-web-stationery-report');
Route::get('requisition_stationery/order-history-report', [WebStationeryReportController::class, 'orderHistoryReport'])
    ->name('requisition_stationery.order-history-report');

Route::get('requisition_stationery/{id}/copy', [RequisitionStationeryController::class, 'copy'])
    ->name('requisition_stationery.copy');
Route::patch('requisition_stationery/{id}/approve', [RequisitionStationeryController::class, 'approve'])
    ->name('requisition_stationery.approve');
Route::patch('requisition_stationery/{id}/cancel', [RequisitionStationeryController::class, 'cancel'])
    ->name('requisition_stationery.cancel');
Route::resource('requisition_stationery', RequisitionStationeryController::class)->only([
    'index', 'create', 'store', 'edit', 'update', 'show'
]);

Route::resource('issue_approve_detail', IssueApproveDetailController::class)->only([
    'index', 'store'
]);

Route::resource('issue_return', IssueReturnController::class)->only([
    'index', 'store'
]);

Route::get('disbursement_fuel/fuel-supply-report', [WebFuelReportController::class, 'fuelSupplyReport'])
    ->name('disbursement_fuel.fuel-supply-report');
Route::get('disbursement_fuel/fuel-supply-pdf', [WebFuelReportController::class, 'createFuelSupplyPDF'])
    ->name('disbursement_fuel.fuel-supply-pdf');
Route::get('disbursement_fuel/fuel-payment-summary-report', [WebFuelReportController::class, 'fuelPaymentSummaryReport'])
    ->name('disbursement_fuel.fuel-payment-summary-report');
Route::get('disbursement_fuel/fuel-payment-summary-pdf', [WebFuelReportController::class, 'createFuelPaymentSummaryPDF'])
    ->name('disbursement_fuel.fuel-payment-summary-pdf');
Route::get('disbursement_fuel/oil-consumption-public-car-report', [WebFuelReportController::class, 'OilConsumptionPublicCarReport'])
    ->name('disbursement_fuel.oil-consumption-public-car-report');
Route::get('disbursement_fuel/oil-consumption-public-car-pdf', [WebFuelReportController::class, 'createOilConsumptionPublicCarPDF'])
    ->name('disbursement_fuel.oil-consumption-public-car-pdf');
Route::get('disbursement_fuel/summary-fuel-type-report', [WebFuelReportController::class, 'summaryFuelTypeReport'])
    ->name('disbursement_fuel.summary-fuel-type-report');
Route::get('disbursement_fuel/summary-fuel-type-pdf', [WebFuelReportController::class, 'createSummaryFuelTypePDF'])
    ->name('disbursement_fuel.summary-fuel-type-pdf');

Route::get('disbursement_fuel/update-car-interface', [DisbursementFuelController::class, 'updateCarInfoInterface'])->name('disbursement_fuel.update-car-interface');
Route::get('disbursement_fuel/update-non-fa-interface', [DisbursementFuelController::class, 'updateNonFaInterface'])->name('disbursement_fuel.update-non-fa-interface');
Route::get('disbursement_fuel/add_new_car', [DisbursementFuelController::class, 'save'])->name('disbursement_fuel.add_new_car');
Route::get('disbursement_fuel/add_non_fa', [DisbursementFuelController::class, 'addNonFa'])->name('disbursement_fuel.add_non_fa');
Route::get('disbursement_fuel/report', [DisbursementFuelController::class, 'report'])->name('disbursement_fuel.report');
Route::get('disbursement_fuel/show', [DisbursementFuelController::class, 'show'])->name('disbursement_fuel.show');
Route::get('disbursement_fuel/{id}/edit-non-fa', [DisbursementFuelController::class, 'editNonFa'])->name('disbursement_fuel.edit-non-fa');
Route::post('disbursement_fuel/{id}/cancel', [DisbursementFuelController::class, 'destroy'])->name('disbursement_fuel.cancel');
Route::resource('disbursement_fuel', DisbursementFuelController::class)->only([
    'index', 'create', 'store', 'edit', 'update', 'destroy'
]);

Route::get('/issue_header', [App\Http\Controllers\INV\Ajex\PtinvIssueHeadersController::class, 'index'])->name('issue_header');
Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::get('/issue_header', [App\Http\Controllers\INV\Ajax\PtinvIssueHeadersController::class, 'index'])->name('issue_header');
    Route::get('/issue_profile_V', [App\Http\Controllers\INV\Ajax\PtinvIssueProfilesVController::class, 'index'])->name('issue_profile_V');
    Route::get('/coa_dept_code', [App\Http\Controllers\INV\Ajax\PtglCoaDeptCodeVController::class, 'index'])->name('coa_dept_code');
    Route::get('/coa_dept_code_all', [App\Http\Controllers\INV\Ajax\PtglCoaDeptCodeAllVController::class, 'index'])->name('coa_dept_code_all');
    Route::get('/subinventory', [App\Http\Controllers\INV\Ajax\PtirSubinventoryController::class, 'index'])->name('subinventory');
    Route::get('/secondary_inventories', [App\Http\Controllers\INV\Ajax\MtlSecondaryInventoriesController::class, 'index'])->name('secondary_inventories');
    Route::get('/alias_name', [App\Http\Controllers\INV\Ajax\PtglAliasNameVController::class, 'index'])->name('alias_name');
    Route::get('/system_item', [App\Http\Controllers\INV\Ajax\MtlSystemItemsBController::class, 'index'])->name('system_item');
    Route::get('/car_info', [App\Http\Controllers\INV\Ajax\PtinvCarInfoVController::class, 'index'])->name('car_info');
    Route::get('/car_history', [App\Http\Controllers\INV\Ajax\PtinvCarHistoryVController::class, 'index'])->name('car_history');
    Route::get('/gl_code_combinations', [App\Http\Controllers\INV\Ajax\GlCodeCombinationsKfvController::class, 'index'])->name('gl_code_combinations');
    Route::get('/web_fuel_dist', [App\Http\Controllers\INV\Ajax\PtinvWebFuelDistController::class, 'index'])->name('web_fuel_dist');
    Route::get('/web_fuel_oil', [App\Http\Controllers\INV\Ajax\PtinvWebFuelOilController::class, 'index'])->name('web_fuel_oil');
    Route::get('/item_locations', [App\Http\Controllers\INV\Ajax\MtlItemLocationsController::class, 'index'])->name('item_locations');
    Route::get('/car_types', [App\Http\Controllers\INV\Ajax\ToatInvCarTypeController::class, 'index'])->name('car_types');
    Route::get('/car_brands', [App\Http\Controllers\INV\Ajax\ToatFaBrandController::class, 'index'])->name('car_brands');
    Route::get('/car_fuels', [App\Http\Controllers\INV\Ajax\ToatInvFuelController::class, 'index'])->name('car_fuels');
    Route::get('/employees', [App\Http\Controllers\INV\Ajax\PerPeopleFController::class, 'index'])->name('employees');
    Route::get('/lookup_types', [App\Http\Controllers\INV\Ajax\FndLookupTypesController::class, 'index'])->name('lookup_types');
    Route::get('/lookup_values', [App\Http\Controllers\INV\Ajax\FndLookupValuesController::class, 'index'])->name('lookup_values');
    Route::get('/organization_units', [App\Http\Controllers\INV\Ajax\HrOrganizationUnitController::class, 'index'])->name('organization_units');
    Route::get('/po_distributions_all', [App\Http\Controllers\INV\Ajax\PoDistributionsAllController::class, 'index'])->name('po_distributions_all');
    Route::get('/po_headers_all', [App\Http\Controllers\INV\Ajax\PoHeadersAllController::class, 'index'])->name('po_headers_all');
    Route::get('/po_lines_all', [App\Http\Controllers\INV\Ajax\PoLinesAllController::class, 'index'])->name('po_lines_all');
    Route::get('/lot_onhands', [App\Http\Controllers\INV\Ajax\MtlLotOnhandSumVController::class, 'index'])->name('lot_onhands');
    Route::get('/cost_centers', [App\Http\Controllers\INV\Ajax\FndFlexValuesVlController::class, 'index'])->name('cost_centers');
});
