<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IR\Settings\CompanyController;
use App\Http\Controllers\IR\Settings\PolicyController;
use App\Http\Controllers\IR\ConfirmToAPController;
use App\Http\Controllers\IR\ConfirmToGLController;
use App\Http\Controllers\IR\ConfirmToARController;
use App\Http\Controllers\IR\ExpenseStockAssetController;
use App\Http\Controllers\IR\ExpenseCarGasController;
use App\Http\Controllers\IR\CalculateInsuranceController;
use App\Http\Controllers\IR\GasStationsController;
use App\Http\Controllers\IR\CarsController;
use App\Http\Controllers\IR\GovernorController;

use App\Http\Controllers\IR\Settings\VehicleController;
use App\Http\Controllers\IR\Settings\GasStationController;
use App\Http\Controllers\IR\Settings\PolicyGroupController;
use App\Http\Controllers\IR\AssetController;
use App\Http\Controllers\IR\StockController;
use App\Http\Controllers\IR\Ajax\Lov\LovController as AjaxLovController;
use App\Http\Controllers\IR\Ajax\Settings\CompanyController as AjaxcompanyController;
use App\Http\Controllers\IR\Ajax\Settings\PolicyController as AjaxPolicyController;
use App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController as AjaxPolicyGroupController;
use App\Http\Controllers\IR\Ajax\Settings\VehiclesController as AjaxVehiclesController;
use App\Http\Controllers\IR\Ajax\Settings\GasStationsController as AjaxGasStationsController;
use App\Http\Controllers\IR\Ajax\StockController as AjaxStockController;
use App\Http\Controllers\IR\Ajax\AssetController as AjaxAssetController;
use App\Http\Controllers\IR\Ajax\CarsController as AjaxCarsController;
use App\Http\Controllers\IR\Ajax\ExtendGasStationController as AjaxExtendGasStationsController;
use App\Http\Controllers\IR\Ajax\PersonsController as AjaxPersonsController;
use App\Http\Controllers\IR\Ajax\ConfirmToApController as AjaxConfirmToApController;
use App\Http\Controllers\IR\Settings\Ajax\AccountMappingController as AjaxAccountsMappingController;
use \App\Http\Controllers\IR\Settings\AccountMappingController;
use App\Http\Controllers\IR\Ajax\ConfirmToArController as AjaxConfirmToArController;
use App\Http\Controllers\IR\Ajax\ConfirmToGlController as AjaxConfirmToGlController;
use App\Http\Controllers\IR\Ajax\ExpenseStockAssetsController as AjaxExpenseStockAssetsController;
use App\Http\Controllers\IR\Ajax\ExpenseCarGasController as AjaxExpenseCarGasController;
use App\Http\Controllers\IR\Ajax\ClaimController as AjaxClaimController;
use App\Http\Controllers\IR\Ajax\ClaimAccountingController as AjaxClaimAccountingController;
use App\Http\Controllers\IR\ClaimInsuranceController; //IRP0010
use App\Http\Controllers\IR\ClaimAccountingController; //IRP0011
use App\Http\Controllers\IR\Settings\Ajax\ProductGroupController;
use App\Http\Controllers\IR\Settings\VehiclesController;

use App\Http\Controllers\IR\Settings\ReportInfoController;
use App\Http\Controllers\IR\ReportsController;
use App\Http\Controllers\IR\Ajax\IrReportsController;

use App\Http\Controllers\IR\Reports\IRR0005_3Controller;
use App\Http\Controllers\IR\Reports\IRR0009_1Controller;
use App\Http\Controllers\IR\Reports\IRR0009_2Controller;
use App\Http\Controllers\IR\Reports\IRR0081_1Controller;
use App\Http\Controllers\IR\Reports\IRR0009_3Controller;
use App\Http\Controllers\IR\Reports\IRR0081_3Controller;
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
Route::middleware(['auth'])->group(function () {
    require base_path('routes/settings/_ir.php');


    // Ajax api
    Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {

        Route::namespace('Lov')->prefix('lov')->name('Lov.')->group(function () {
            Route::get('defaultirp0007', [AjaxLovController::class, 'defaultirp0007'])->name('lov-defaultirp0007');
            Route::get('companies', [AjaxLovController::class, 'companiesLov'])->name('lov-companies');
            Route::get('vendor', [AjaxLovController::class, 'supplierNumberLov'])->name('lov-vendor');
            Route::get('branch-code', [AjaxLovController::class, 'branchNumberLov'])->name('lov-branch-code');
            Route::get('customer-number', [AjaxLovController::class, 'customerNumberLov'])->name('lov-customer-number');
            Route::get('policy-set-header', [AjaxLovController::class, 'policySetHeadersLov'])->name('lov-policy-set-header');
            Route::get('policy-type', [AjaxLovController::class, 'policyTypeLov'])->name('lov-policy-type');
            Route::get('account-code-combine', [AjaxLovController::class, 'accountCodeCombineLov'])->name('lov-account-code-combine');
            Route::get('gas-station-group', [AjaxLovController::class, 'gasStationGroupLov'])->name('lov-gas-stations-groups');
            Route::get('group-code', [AjaxLovController::class, 'groupLov'])->name('lov-group');
            Route::get('policy-category', [AjaxLovController::class, 'policyCategoryLov'])->name('lov-policy-category');
            Route::get('policy-group-header', [AjaxLovController::class, 'policyGroupHeaderLov'])->name('lov-policy-group-headers');
            Route::get('premium-rate', [AjaxLovController::class, 'premiumRateLov'])->name('lov-premium-rate');
            Route::get('company-code', [AjaxLovController::class, 'companiesCodeLov'])->name('companies-code');
            Route::get('evm-code', [AjaxLovController::class, 'evmCodeLov'])->name('lov-evm-code');
            Route::get('department-code', [AjaxLovController::class, 'departmentCodeLov'])->name('lov-department-code');
            Route::get('cost-center-code', [AjaxLovController::class, 'costCenterCodeLov'])->name('lov-cost-center-code');
            Route::get('budget-year', [AjaxLovController::class, 'budgetYearLov'])->name('lov-budget-year');
            Route::get('budget-type', [AjaxLovController::class, 'budgetTypeLov'])->name('lov-budget-type');
            Route::get('budget-detail', [AjaxLovController::class, 'budgetDetailLov'])->name('lov-budget-detail');
            Route::get('budget-reason', [AjaxLovController::class, 'budgetReasonLov'])->name('lov-budget-reason');
            Route::get('main-account', [AjaxLovController::class, 'mainAccountLov'])->name('lov-main-account');
            Route::get('sub-account', [AjaxLovController::class, 'subAccountLov'])->name('lov-sub-account');
            Route::get('reserved1', [AjaxLovController::class, 'reserved1'])->name('lov-reserverd1');
            Route::get('reserved2', [AjaxLovController::class, 'reserved2'])->name('lov-reserverd2');
            Route::get('license-plate', [AjaxLovController::class, 'licensePlateLov'])->name('lov-license-plate');
            Route::get('vehicles-type', [AjaxLovController::class, 'vehiclesTypeLov'])->name('lov-vehicles-type');
            Route::get('renew-type', [AjaxLovController::class, 'renewTypeLov'])->name('lov-renew-type');
            Route::get('renew-type-irm0007', [AjaxLovController::class, 'renewTypeLovIRM07'])->name('lov-renew-type');
            Route::get('gas-stations-type', [AjaxLovController::class, 'gasStationTypeLov'])->name('lov-gas-stations-type');
            Route::get('status', [AjaxLovController::class, 'statusLov'])->name('lov-status');
            Route::get('periods', [AjaxLovController::class, 'periodsLov'])->name('lov-periods');
            Route::get('group-location', [AjaxLovController::class, 'groupLocationLov'])->name('lov-group-location');
            Route::get('sub-group', [AjaxLovController::class, 'subGroupLov'])->name('lov-sub-group');
            Route::get('org', [AjaxLovController::class, 'orgLov'])->name('lov-org');
            Route::get('sub-inventory', [AjaxLovController::class, 'subInventoryLov'])->name('lov-sub-inventory');
            Route::get('uom', [AjaxLovController::class, 'uomLov'])->name('lov-uom');
            Route::get('invoice-type', [AjaxLovController::class, 'invoiceTypeLov'])->name('lov-invoice');
            Route::get('governer-policy-type', [AjaxLovController::class, 'governerPolicyTypeLov'])->name('lov-governer-policy-type');
            Route::get('invoice-number', [AjaxLovController::class, 'invoiceNumberLov'])->name('lov-invoice-number');
            Route::get('interface-type', [AjaxLovController::class, 'apInterfaceTypeLov'])->name('lov-interface-type');
            Route::get('interface-gl-type', [AjaxLovController::class, 'glInterfaceTypeLov'])->name('lov-interface-gl-type');
            Route::get('department-location', [AjaxLovController::class, 'departmentLocationLov'])->name('lov-department-location');
            Route::get('location', [AjaxLovController::class, 'locationLov'])->name('lov-location');
            Route::get('cat-segment1', [AjaxLovController::class, 'catSegment1Lov'])->name('lov-cat-segment1');
            Route::get('cat-segment3', [AjaxLovController::class, 'catSegment3Lov'])->name('lov-cat-segment3');
            Route::get('receivable-charge', [AjaxLovController::class, 'receivableChargeLov'])->name('lov-receivable-charge');
            Route::get('effective-date', [AjaxLovController::class, 'effectiveDateLov'])->name('lov-effective-date');
            Route::get('exp-asset-stock-type', [AjaxLovController::class, 'expAssetStockTypeLov'])->name('lov-exp-asset-stock-type');
            Route::get('exp-car-gas-type', [AjaxLovController::class, 'expCarGasTypeLov'])->name('lov-exp-car-gas-type');
            Route::get('ar-invoice-num', [AjaxLovController::class, 'arInvoiceNumLov'])->name('lov-ar-invoice-num');
            Route::get('policy-vehicles', [AjaxLovController::class, 'policySetHeadersVehicleLov'])->name('lov-policy-vehicle');
            Route::get('group-code-policy', [AjaxLovController::class, 'groupCodePolicyLov'])->name('lov-group-code-policy');
            Route::get('revision', [AjaxLovController::class, 'revisionLov'])->name('lov-revision');
            Route::get('budget-period-year', [AjaxLovController::class, 'budgetPeriodYearLov'])->name('lov-budget-period_year');
            Route::get('asset-status', [AjaxLovController::class, 'assetStatusLov'])->name('lov-asset-status');
            Route::get('vehicle-license-plate', [AjaxLovController::class, 'getVehicleLicensePlateLov'])->name('lov-vehicle-license-plate');
            Route::get('gas-station-type-master', [AjaxLovController::class, 'gasStationTypeMasterLov'])->name('lov-gas-station-type-master');
            Route::get('claim-document-number', [AjaxLovController::class, 'claimDocumentNumberLov'])->name('lov-claim-document-number');
            Route::get('ar-document-number', [AjaxLovController::class, 'ARDocumentNumberLov'])->name('lov-ar-document-number');
            Route::get('irp-document-number', [AjaxLovController::class, 'irpDocumentNumberLov'])->name('lov-irp-document-number');
            Route::get('gen-company-number', [AjaxLovController::class, 'genCompanyNumber'])->name('lov-gen-company-number');
            Route::get('claim-policy-number', [AjaxLovController::class, 'policySetHeadersClaimLov'])->name('lov-claim-policy-number');
            Route::get('company-percent', [AjaxLovController::class, 'companyPercent'])->name('lov-company-percent');
            Route::get('policy-set-header-group', [AjaxLovController::class, 'policyFromPolicyGroup'])->name('lov-policy-set-header-group');
            Route::get('vehicle-brand', [AjaxLovController::class, 'vehicleBrand'])->name('lov-vehicle-brand');
            Route::get('category-seg4', [AjaxLovController::class, 'categorySeg4'])->name('lov-category4');
            Route::get('category-seg5', [AjaxLovController::class, 'categorySeg5'])->name('lov-category5');
            Route::get('asset-group', [AjaxLovController::class, 'assetGroup'])->name('lov-asset-group');
            Route::get('asset-group-by-product', [AjaxLovController::class, 'assetGroupByProduct'])->name('lov-asset-group-by-product');
            Route::get('ap-interface-type', [AjaxLovController::class, 'arInterfaceType'])->name('lov-ap-interface-type');
            Route::get('vehicle-rate', [AjaxLovController::class, 'vehicleRate'])->name('lov-vehicle-rate');
            Route::get('group-products', [AjaxLovController::class, 'getGroupProducts']);
            Route::get('items', [AjaxLovController::class, 'getItems']);
            Route::get('location-seg2', [AjaxLovController::class, 'getLocationSeg2']);
            Route::get('period-year', [AjaxLovController::class, 'getDefaultPeriodYear']);
            Route::get('person-account', [AjaxLovController::class, 'getDefaultAccountForGovernor']);
            Route::get('category-seg4-vehicle', [AjaxLovController::class, 'categorySeg4Vehicle'])->name('lov-category4-vehicle');
        });

        //Companies(irm0001)
        Route::get('company', [AjaxcompanyController::class, 'index'])->name('company-index');
        Route::get('company/{company_id}', [AjaxcompanyController::class, 'show'])->name('company-show');
        Route::get('check-duplicate/company', [AjaxcompanyController::class, 'checkDuplicateData'])->name('company-check-duplicate');
        Route::post('company', [AjaxcompanyController::class, 'store'])->name('company-store');
        Route::put('company', [AjaxcompanyController::class, 'update'])->name('company-update');
        Route::put('company/active-flag', [AjaxcompanyController::class, 'updateActiveFlag'])->name('company-active-flag');
        Route::put('company/check-used-data/{company_id}', [AjaxcompanyController::class, 'checkUsedData'])->name('company-check-used-data');
        //Policy(irm0002)
        Route::get('policy', [AjaxPolicyController::class, 'index'])->name('policy-index');
        Route::get('policy/{policy_set_header_id}', [AjaxPolicyController::class, 'show'])->name('policy-show');
        Route::post('policy/save', [AjaxPolicyController::class, 'store'])->name('policy-store');
        Route::put('policy/update', [AjaxPolicyController::class, 'update'])->name('policy-update');
        Route::put('policy/active-flag', [AjaxPolicyController::class, 'updateActiveFlag'])->name('policy-update-active-flag');
        Route::put('policy/check-used-data/{policy_set_header_id}', [AjaxPolicyController::class, 'checkUsedData'])->name('policy-check-used-data');
        //Policy group(irm0003)
        Route::get('policy-group', [AjaxPolicyGroupController::class, 'index'])->name('policy-group-header-index');
        Route::post('policy-group/overlap-check', [AjaxPolicyGroupController::class, 'overlapCheck'])->name('policy-group-header-overlap-check');
        Route::get('policy-group/{group_header_id}', [AjaxPolicyGroupController::class, 'show'])->name('policy-group-header-show');
        Route::get('group-dists', [AjaxPolicyGroupController::class, 'subDetail'])->name('policy-group-header-group-dists');
        Route::post('policy-group/save', [AjaxPolicyGroupController::class, 'store'])->name('policy-group-header-store');
        Route::post('policy-group/save-index', [AjaxPolicyGroupController::class, 'storeIndex'])->name('policy-group-header-store-index');
        Route::delete('policy-group/group-sets', [AjaxPolicyGroupController::class, 'deletePolicyGroupSet'])->name('policy-group-set-delete');
        Route::put('policy-group/update-active-flag', [AjaxPolicyGroupController::class, 'updateActiveFlag'])->name('policy-group-header-update-active-flag');
        Route::get('policy-group/duplicate-check/{policy_set_header_id}', [AjaxPolicyGroupController::class, 'policyDuplicateCheck'])->name('policy-group-header-duplicate-check');
        Route::get('policy-group/overlap-check', [AjaxPolicyGroupController::class, 'overlapCheck']);
        //Vehicles(irm0007)
        Route::get('vehicles', [AjaxVehiclesController::class, 'index'])->name('vehicles-index');
        Route::get('vehicles/edit', [AjaxVehiclesController::class, 'show'])->name('vehicles-show');
        Route::post('vehicles', [AjaxVehiclesController::class, 'createOrUpdate'])->name('vehicles-create-or-update');
        Route::put('vehicles/active-flag', [AjaxVehiclesController::class, 'updateActiveFlag'])->name('vehicles-active-flag');
        Route::put('vehicles/return-vat-flag', [AjaxVehiclesController::class, 'updateReturnVatFlag'])->name('vehicles-return-vat-flag');
        Route::put('vehicles/sold-flag', [AjaxVehiclesController::class, 'updateSoldFlag'])->name('vehicles-sold-flag');
        Route::get('vehicles/duplicate-check', [AjaxVehiclesController::class, 'duplicateCheck'])->name('vehicles-duplicate-check');
        Route::get('vehicles/getlookupData', [AjaxVehiclesController::class, 'getlookupData'])->name('vehicles.getlookupData');
        Route::get('vehicles/update-flag', [AjaxVehiclesController::class, 'updateActive'])->name('vehicles.updateActive');
        // 20220408
        Route::get('vehicles/get-coa', [AjaxVehiclesController::class, 'getCoaLists']);
        Route::get('vehicles/get-coa-desc', [AjaxVehiclesController::class, 'getCoaDescription']);
        //Gas Stations(IRM0008)
        Route::get('gas-stations', [AjaxGasStationsController::class, 'index'])->name('gas-stations-index');
        Route::get('gas-stations/{gas_station_id}', [AjaxGasStationsController::class, 'show'])->name('gas-stations-show');
        Route::post('gas-stations', [AjaxGasStationsController::class, 'store'])->name('gas-stations-store');
        Route::put('gas-stations', [AjaxGasStationsController::class, 'update'])->name('gas-stations-update');
        Route::put('gas-stations/return-vat-flag', [AjaxGasStationsController::class, 'updateReturnVatFlag'])->name('gas-stations-return-vat-flag');
        Route::put('gas-stations/active-flag', [AjaxGasStationsController::class, 'updateActiveFlag'])->name('gas-stations-active-flag');
        //Stock(IRP0001-IRP0002)
        Route::get('stocks', [AjaxStockController::class, 'index'])->name('stocks-index');
        Route::get('stocks/check-fetch', [AjaxStockController::class, 'checkFetch'])->name('stocks-check-fetch');
        Route::get('stocks/fetch', [AjaxStockController::class, 'fetch'])->name('stocks-fetch');
        Route::get('stocks/show', [AjaxStockController::class, 'show'])->name('stocks-show');
        Route::post('stocks', [AjaxStockController::class, 'createOrUpdate'])->name('stocks-create-or-update');
        //Asset(IRP0003-IRP0004)
        Route::get('asset', [AjaxAssetController::class, 'index'])->name('asset-index');
        Route::get('asset/fetch', [AjaxAssetController::class, 'fetch'])->name('asset-fetch');
        Route::get('asset/asset-adjust', [AjaxAssetController::class, 'indexAdjustHeaders'])->name('asset-index-adjust');
        Route::get('asset/asset-adjust/fetch', [AjaxAssetController::class, 'fetchAdjustment'])->name('asset-fetch-adjust');
        Route::get('asset/show', [AjaxAssetController::class, 'show'])->name('asset-show');
        Route::get('asset/asset-adjust/show', [AjaxAssetController::class, 'showAdjustLines'])->name('asset-show-adjust');
        Route::post('asset', [AjaxAssetController::class, 'createOrUpdate'])->name('asset-create-or-update');
        Route::get('asset/input-irp/{id}/{program_code}', [AjaxAssetController::class, 'inputFilterIrp'])->name('asset-input-irp');
        Route::get('asset/validate-account', [AjaxAssetController::class, 'validateAccount'])->name('validateAccount');
        Route::post('asset/delete', [AjaxAssetController::class, 'destroy'])->name('asset-destroy');
        Route::get('asset/check-duplicate', [AjaxAssetController::class, 'checkDuplicate'])->name('asset-check-duplicate');

        //Cars(IRP0005)
        Route::get('cars', [AjaxCarsController::class, 'index'])->name('cars-index');
        Route::get('cars/fetch', [AjaxCarsController::class, 'fetch'])->name('cars-fetch');
        Route::post('cars', [AjaxCarsController::class, 'createOrUpdate'])->name('cars-create-or-update');
        Route::post('cars/duplicate-check', [AjaxCarsController::class, 'duplicateCheck'])->name('cars-duplicate-check');
        Route::post('cars/remove', [AjaxCarsController::class, 'remove'])->name('cars-remove');
        Route::put('cars/status', [AjaxCarsController::class, 'updateStatus'])->name('cars-status');
        //Extend gas station(IRP0006)
        Route::get('extend-gas-stations', [AjaxExtendGasStationsController::class, 'index'])->name('extend-gas-stations-index');
        Route::get('extend-gas-stations/check-fetch', [AjaxExtendGasStationsController::class, 'checkFetch'])->name('extend-gas-stations-check-fetch');
        Route::get('extend-gas-stations/fetch', [AjaxExtendGasStationsController::class, 'fetch'])->name('extend-gas-stations-fetch');
        Route::post('extend-gas-stations', [AjaxExtendGasStationsController::class, 'createOrUpdate'])->name('extend-gas-stations-create-or-update');
        Route::post('extend-gas-stations/duplicate-check', [AjaxExtendGasStationsController::class, 'duplicateCheck'])->name('extend-gas-stations-duplicate-check');
        Route::get('extend-gas-stations/status', [AjaxExtendGasStationsController::class, 'updateStatus'])->name('extend-gas-stations-status');
        Route::post('extend-gas-stations/delete', [AjaxExtendGasStationsController::class, 'destroy'])->name('extend-gas-stations-destroy');
        //Persons(IRP0007)
        Route::get('persons', [AjaxPersonsController::class, 'index'])->name('persons-index');
        Route::post('persons', [AjaxPersonsController::class, 'createOrUpdate'])->name('persons-create-or-update');
        Route::post('persons/duplicate-check', [AjaxPersonsController::class, 'duplicateCheck'])->name('persons-duplicate-check');
        Route::post('persons/duplicate-check/invoice-number', [AjaxPersonsController::class, 'invoiceNumberCheck'])->name('persons-duplicate-check-invoice-number');
        Route::get('persons/status', [AjaxPersonsController::class, 'updateStatus'])->name('persons-status');
        Route::post('persons/delete', [AjaxPersonsController::class, 'destroy'])->name('persons-destroy');
        //Expense asset stock(IRP0008)
        Route::get('expense-asset-stock/check-fetch', [AjaxExpenseStockAssetsController::class, 'checkFetch'])->name('expense-asset-stock-check-fetch');
        Route::get('expense-asset-stock/fetch', [AjaxExpenseStockAssetsController::class, 'fetch'])->name('expense-asset-stock-fetch');
        Route::get('expense-asset-stock', [AjaxExpenseStockAssetsController::class, 'index'])->name('expense-asset-stock-index');
        Route::post('expense-asset-stock', [AjaxExpenseStockAssetsController::class, 'store'])->name('expense-asset-stock-store');
        //Expense car gas(IRP0009)
        Route::get('expense-car-gas/check-fetch', [AjaxExpenseCarGasController::class, 'checkFetch'])->name('expense-car-gas-check-fetch');
        Route::get('expense-car-gas', [AjaxExpenseCarGasController::class, 'index'])->name('expense-car-gas-index');
        Route::get('expense-car-gas/fetch', [AjaxExpenseCarGasController::class, 'fetch'])->name('expense-car-gas-fetch');
        Route::post('expense-car-gas', [AjaxExpenseCarGasController::class, 'store'])->name('expense-car-gas-store');

        // Claim IRP0010 Piyawut A 27032022 -- Agency
        Route::post('claim-insurance/store', [AjaxClaimController::class, 'store'])->name('claim-insurance.store');
        Route::post('claim-insurance/{claim_header_id}/update', [AjaxClaimController::class, 'update'])->name('claim-insurance.update');
        Route::get('claim-insurance/{claim_header_id}/cancel', [AjaxClaimController::class, 'cancel'])->name('claim-insurance.cancel');
        Route::post('claim-insurance/delete-file', [AjaxClaimController::class, 'deleteFile'])->name('claim-insurance.delete-file');
        Route::post('claim-insurance/get-data-default', [AjaxClaimController::class, 'getDataDefault'])->name('claim-insurance.get-data-default');
        Route::post('claim-insurance/{claim_header_id}/confirm', [AjaxClaimController::class, 'confirmClaim'])->name('claim-insurance.confirm');
        Route::post('claim-insurance/{claim_header_id}/attachment', [AjaxClaimController::class, 'storeFileUpload'])->name('claim-insurance.attachment');
        Route::post('claim-insurance/delete-file', [AjaxClaimController::class, 'deleteFile'])->name('claim-insurance.delete-file');

        // Claim IRP0011 Piyawut A 08052022 -- Accounting
        Route::post('claim-accounting/{claim_header_id}/update', [AjaxClaimAccountingController::class, 'update'])->name('claim-accounting.update');
        Route::get('claim-accounting/{attachment_id}/download', [AjaxClaimAccountingController::class, 'download'])->name('claim-accounting.download');
        Route::post('claim-accounting/{claim_header_id}/attachment', [AjaxClaimAccountingController::class, 'storeFileUpload'])->name('claim-accounting.attachment');
        Route::post('claim-accounting/get-data-default', [AjaxClaimAccountingController::class, 'getDataDefault'])->name('claim-accounting.get-data-default');
        Route::post('claim-accounting/{claim_header_id}/confirm', [AjaxClaimAccountingController::class, 'confirmClaim'])->name('claim-accounting.confirm');
        Route::get('claim-accounting/{claim_header_id}/cancel', [AjaxClaimAccountingController::class, 'cancel'])->name('claim-accounting.cancel');
        Route::get('claim-accounting/{claim_header_id}/update-confirm', [AjaxClaimAccountingController::class, 'updateConfirm'])->name('claim-accounting.update-confirm');
        Route::post('claim-accounting/{claim_header_id}/update-cliam-header', [AjaxClaimAccountingController::class, 'updateCliamHeader'])->name('claim-accounting.update-cliam-header');
        Route::post('claim-accounting/delete-file', [AjaxClaimAccountingController::class, 'deleteFile'])->name('claim-accounting.delete-file');
        Route::post('claim-accounting/{claim_header_id}/delete-policy', [AjaxClaimAccountingController::class, 'deleteClaimPolicy'])
            ->name('claim-accounting.delete-policy');
        Route::post('claim-accounting/{claim_header_id}/delete-detail', [AjaxClaimAccountingController::class, 'deleteClaimDetail'])
            ->name('claim-accounting.delete-detail');

        //Confirm to ap (IRP00013)
        Route::get('confirm-ap', [AjaxConfirmToApController::class, 'interfaceAp'])->name('confirm-ap-interface');
        Route::get('confirm-ap/cancel', [AjaxConfirmToApController::class, 'cancel'])->name('confirm-ap-cancel');
        Route::get('confirm-ap/report', [AjaxConfirmToApController::class, 'report'])->name('confirm-ap-report');
        // Piyawut A. 20211112
        Route::post('confirm-ap/get-group-id', [AjaxConfirmToApController::class, 'getDataGroupId']);
        Route::post('confirm-ap/get-ap-batch', [AjaxConfirmToApController::class, 'getDefaultAPBatch']);
        //Confirm to gl (IRP00014)
        Route::get('confirm-gl', [AjaxConfirmToGlController::class, 'interfaceGl'])->name('confirm-gl-interface');
        Route::get('confirm-gl/cancel', [AjaxConfirmToGlController::class, 'cancel'])->name('confirm-gl-cancel');
        Route::get('confirm-gl/report', [AjaxConfirmToGlController::class, 'report'])->name('confirm-gl-report');
        //Confirm to ar (IRP00015)
        Route::get('confirm-ar', [AjaxConfirmToArController::class, 'interfaceAr'])->name('confirm-ar-interface');
        Route::get('confirm-ar/cancel', [AjaxConfirmToArController::class, 'cancel'])->name('confirm-ar-cancel');
        Route::get('confirm-ar/report', [AjaxConfirmToArController::class, 'report'])->name('confirm-ar-report');

        //AccountsMapping
        // Route::get('coa-mapping', [AjaxAccountsMappingController::class, 'index'])->name('account-mapping.index');
        // Route::get('cost-center', [AjaxAccountsMappingController::class, 'costCenter'])->name('cost-center');

        // Route::get('inquiry-funds', [InquiryFundsController::class, 'index'])->name('funds.index');
        Route::get('coa-mapping', [AjaxAccountsMappingController::class, 'index'])->name('account-mapping.index');
        Route::get('validate-combination', [AjaxAccountsMappingController::class, 'validateCombination'])->name('validate-combination');

        Route::get('companies/all', [AjaxCompaniesController::class, 'searchCompanies'])->name('search-companies');
        Route::get('vendor/all', [AjaxCompaniesController::class, 'supplierNumber'])->name('vendor');
        Route::get('branchcode/all', [AjaxCompaniesController::class, 'branchNumber'])->name('branchcode');
        Route::get('customernumber/all', [AjaxCompaniesController::class, 'customerNumber'])->name('customernumber');
        Route::get('companies/update/activeflag', [AjaxCompaniesController::class, 'editActiveFlag'])->name('companies-update-activeflag');
        Route::get('companies/lov/companies', [AjaxCompaniesController::class, 'companiesLov'])->name('companies-lov');

        Route::get('account-mapping', [AjaxAccountsMappingController::class, 'showAccountMapping'])->name('show-account-mapping');
        Route::get('companies-code/all', [AjaxAccountsMappingController::class, 'companiesCode'])->name('companies-code');
        Route::get('evm-code/all', [AjaxAccountsMappingController::class, 'evmCode'])->name('evm-code');
        Route::get('department-code/all', [AjaxAccountsMappingController::class, 'departmentCode'])->name('department-code');
        Route::get('costcenter-code/all', [AjaxAccountsMappingController::class, 'costCenterCode'])->name('costcenter-code');
        Route::get('budget-year/all', [AjaxAccountsMappingController::class, 'budgetYear'])->name('budget-year');
        Route::get('budget-type/all', [AjaxAccountsMappingController::class, 'budgetType'])->name('budget-type');
        Route::get('budget-detail/all', [AjaxAccountsMappingController::class, 'budgetDetail'])->name('budget-detail');
        Route::get('budget-reason/all', [AjaxAccountsMappingController::class, 'budgetReason'])->name('budget-reason');
        Route::get('main-account/all', [AjaxAccountsMappingController::class, 'mainAccount'])->name('main-account');
        Route::get('sub-account/all', [AjaxAccountsMappingController::class, 'subAccount'])->name('sub-account');
        Route::get('reserved1/all', [AjaxAccountsMappingController::class, 'reserved1'])->name('reserverd1');
        Route::get('reserved2/all', [AjaxAccountsMappingController::class, 'reserved2'])->name('reserverd2');
        Route::get('account-mapping/lov/account-code-combine', [AjaxAccountsMappingController::class, 'accountCodeCombineLov'])->name('code-combine-lov');

        //เรียก Desction Account
        Route::get('get-account-desc', [AjaxAccountsMappingController::class, 'getAccountDesc'])->name('account-desc');

        //Vehicle
        Route::get('vehicles/lov/license-plate', [AjaxVehiclesController::class, 'licensePlateLov'])->name('vehicles-lov-license-plate');
        Route::get('vehicles/lov/vehicles-type', [AjaxVehiclesController::class, 'vehiclesTypeLov'])->name('vehicles-lov-type');
        Route::get('vehicles', [AjaxVehiclesController::class, 'index'])->name('vehicles-index');
        Route::get('vehicles/show', [AjaxVehiclesController::class, 'show'])->name('vehicles-show');
        Route::post('vehicles/updateOrCreate', [AjaxVehiclesController::class, 'updateOrCreate'])->name('vehicles-update-or-create');
        Route::post('vehicles/update/active-flag', [AjaxVehiclesController::class, 'updateActiveFlag'])->name('vehicles-update-active-flag');
        Route::post('vehicles/update/return-vat-flag', [AjaxVehiclesController::class, 'updateReturnVatFlag'])->name('vehicles-update-return-vat-flag');

        // Route::get('gas-stations/lov/type', [AjaxGasStationsController::class, 'gasStationTypeLov'])->name('gas-stations-lov-type');
        Route::get('gas-stations/lov/lookup-type', [AjaxGasStationsController::class, 'lookupGasStationTypeLov'])->name('lookup-gas-stations-lov-type');
        Route::get('gas-stations/lov/lookup-group', [AjaxGasStationsController::class, 'lookupGasStationGroupsLov'])->name('lookup-gas-stations-lov-groups');
        Route::get('gas-stations', [AjaxGasStationsController::class, 'index'])->name('gas-stations-index');
        Route::get('gas-stations/{gas_station_id}', [AjaxGasStationsController::class, 'show'])->name('gas-stations-show');
        Route::post('gas-stations/save', [AjaxGasStationsController::class, 'store'])->name('gas-stations-store');
        Route::post('gas-stations/update', [AjaxGasStationsController::class, 'update'])->name('gas-stations-update');
        Route::post('gas-stations/update/return-vat-flag', [AjaxGasStationsController::class, 'updateReturnVatFlag'])->name('gas-stations-update-return-vat-flag');
        Route::post('gas-stations/update/active-flag', [AjaxGasStationsController::class, 'updateActiveFlag'])->name('gas-stations-update-active-flag');

        Route::get('ir-report-get-info', [IrReportsController::class, 'getInfo'])->name('ir-report-get-info');
        Route::get('ir-report-get-info-attribute', [IrReportsController::class, 'getInfoAttribute'])->name('ir-report-get-info-attribute');
        Route::get('ir-report-submit', [IrReportsController::class, 'irReportSubmit'])->name('ir-report-submit');
    });



    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('account-mapping/save', [AjaxAccountsMappingController::class, 'store'])->name('store-account-mapping');
        Route::post('account-mapping/update', [AjaxAccountsMappingController::class, 'update'])->name('update-account-mapping');
        // test api
        Route::get('companies/all', [CompaniesController::class, 'getCompanies'])->name('companies');
        // api
        Route::post('companies/save', [CompaniesController::class, 'store'])->name('companies-store');
        Route::post('companies/update', [CompaniesController::class, 'update'])->name('companies-update');

        //  Route::post('account-mapping/save', [AjaxAccountsMappingController::class, 'store'])->name('store-account-mapping');
        //  Route::post('account-mapping/update', [AjaxAccountsMappingController::class, 'update'])->name('update-account-mapping');

        // web
        Route::get('policy', [PolicyController::class, 'index'])->name('policy.index');
        Route::get('policy/create', [PolicyController::class, 'create'])->name('policy.create');
        Route::get('policy/edit/{id}', [PolicyController::class, 'edit'])->name('policy.edit');

        Route::get('vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::get('vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
        Route::get('vehicle/edit/{asset_id}/{vehicle_id}', [VehicleController::class, 'edit'])->name('vehicle.edit');

        Route::get('gas-stations', [GasStationsController::class, 'index'])->name('gas-stations.index');
        Route::get('gas-stations/create', [GasStationsController::class, 'create'])->name('gas-stations.create');
        Route::get('gas-stations/edit', [GasStationsController::class, 'edit'])->name('gas-stations.edit');

        Route::get('policies', [PolicyController::class, 'index'])->name('policies.index');
        Route::get('policies/create', [PolicyController::class, 'create'])->name('policies.create');
        Route::get('policies/edit/{settings}', [PolicyController::class, 'edit'])->name('policies.edit');

        Route::get('policy-group', [PolicyGroupController::class, 'index'])->name('policy-group.index');
        Route::get('policy-group/edit/{id}', [PolicyGroupController::class, 'edit'])->name('policy-group.edit');

        Route::get('ar-oracle', [AROracleController::class, 'index'])->name('ar-oracle.index');
        Route::get('gl-oracle', [GLOracleController::class, 'index'])->name('gl-oracle.index');
        Route::get('irp-0008', [ExpenseStockAssetController::class, 'index'])->name('irp-0008.index');
        Route::get('irp-0012', [IRP0012Controller::class, 'index'])->name('irp-0012.index');

        Route::get('report-info', [ReportInfoController::class, 'index'])->name('report-info.index');
        Route::get('report-info/{program}', [ReportInfoController::class, 'show'])->name('report-info.show');
        Route::post('report-info/{program}', [ReportInfoController::class, 'store'])->name('report-info.store');
        Route::post('report-info/{program}/{info}', [ReportInfoController::class, 'update'])->name('report-info.update');
        Route::post('report-info/{program}/{info}/delete', [ReportInfoController::class, 'destroy'])->name('report-info.destroy');


        // Route::get('report-info', [ReportInfoController::class, 'index'])->name('report-info.index');
        // Route::get('report-info/{program}', [ReportInfoController::class, 'show'])->name('report-info.show');
        // Route::post('report-info/{program}', [ReportInfoController::class, 'store'])->name('report-info.store');
        // Route::post('report-info/{program}/{info}', [ReportInfoController::class, 'update'])->name('report-info.update');
        // Route::post('report-info/{program}/{info}/delete', [ReportInfoController::class, 'destroy'])->name('report-info.destroy');

        Route::get('company', [CompanyController::class, 'index'])->name('company.index');
        Route::get('company/create', [CompanyController::class, 'create'])->name('company.create');
        Route::get('company/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');

        Route::get('vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::get('vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
        Route::get('vehicle/get_fa_location', [VehicleController::class, 'getFALocation'])->name('vehicle.get_fa_location');
        Route::get('vehicle/export', [VehicleController::class, 'export'])->name('vehicle.export');

        Route::get('gas-station', [GasStationController::class, 'index'])->name('gas-station.index');

        //Mapping Account
        Route::resource('account-mapping', AccountMappingController::class);

        Route::get('product-group', [ProductGroupController::class, 'index'])->name('product-group');
        Route::get('get-locator', [ProductGroupController::class, 'getLocator'])->name('get-locator');

        Route::get('sub-groups/show/{policy_set_header_id}', [AjaxGroupsController::class, 'show'])->name('sub-groups.show');

        Route::get('gas-station/create', [GasStationController::class, 'create'])->name('gas-station.create');
        Route::get('gas-station/edit/{id}', [GasStationController::class, 'edit'])->name('gas-station.edit');
    });

    Route::prefix('stocks')->name('stocks.')->group(function () {
        Route::get('yearly', [StockController::class, 'yearly'])->name('yearly.index');
        Route::get('yearly/edit/{id}', [StockController::class, 'yearlyEdit'])->name('yearly.edit');
        Route::get('yearly/export', [StockController::class, 'yearlyExport'])->name('yearly.export');

        Route::get('monthly', [StockController::class, 'monthly'])->name('monthly.index');
        Route::get('monthly/edit/{id}', [StockController::class, 'monthlyEdit'])->name('monthly.edit');
        Route::get('monthly/export', [StockController::class, 'monthlyExport'])->name('monthly.export');
    });

    Route::prefix('assets')->name('assets.')->group(function () {
        Route::get('asset-plan', [AssetController::class, 'plan'])->name('asset-plan.index');
        Route::get('asset-plan/edit/{id}', [AssetController::class, 'planEdit'])->name('asset-plan.edit');
        Route::get('asset-plan/export', [AssetController::class, 'planExport'])->name('asset-plan.export');

        Route::get('asset-increase', [AssetController::class, 'increase'])->name('asset-increase.index');
        Route::get('asset-increase/edit/{id}', [AssetController::class, 'increaseEdit'])->name('asset-increase.edit');
        Route::get('asset-increase/export', [AssetController::class, 'increaseExport'])->name('asset-increase.export');
    });

    Route::prefix('gas-stations')->name('gas-stations.')->group(function () {
        Route::get('gas-station', [GasStationsController::class, 'index'])->name('gas-station.index');
        Route::get('gas-station/export', [GasStationsController::class, 'export'])->name('gas-station.export');
    });

    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('car', [CarsController::class, 'index'])->name('car.index');
        Route::get('car/export', [CarsController::class, 'export'])->name('car.export');
    });

    Route::prefix('governors')->name('governors.')->group(function () {
        Route::get('governor', [GovernorController::class, 'index'])->name('governor.index');
    });

    // Route::prefix('claim')->name('claim.')->group(function () {
    //     Route::get('claim-insurance', [ClaimInsuranceController::class, 'index'])->name('claim-insurance.index');
    //     Route::get('claim-insurance/{id}/edit', [ClaimInsuranceController::class, 'edit'])->name('claim-insurance.edit');
    // });

    Route::get('calculate-insurance', [CalculateInsuranceController::class, 'index'])->name('calculate-insurance.index');
    Route::post('calculate-insurance/check-report', [CalculateInsuranceController::class, 'checkReport'])->name('calculate-insurance.check-report');
    Route::get('calculate-insurance/report', [CalculateInsuranceController::class, 'report'])->name('calculate-insurance.report');
    Route::post('calculate-insurance/interface', [CalculateInsuranceController::class, 'interface'])->name('calculate-insurance.interface');
    Route::post('calculate-insurance/cancel', [CalculateInsuranceController::class, 'cancel'])->name('calculate-insurance.cancel');

    Route::get('expense-stock-asset', [ExpenseStockAssetController::class, 'index'])->name('expense-stock-asset.index');
    Route::get('expense-car-gas', [ExpenseCarGasController::class, 'index'])->name('expense-car-gas.index');

    // IRP0010
    Route::get('claim-insurance', [ClaimInsuranceController::class, 'index'])->name('claim-insurance.index');
    Route::get('claim-insurance/create', [ClaimInsuranceController::class, 'create'])->name('claim-insurance.create');
    Route::get('claim-insurance/{claimHeader}', [ClaimInsuranceController::class, 'edit'])->name('claim-insurance.edit');
    Route::get('claim-insurance/{claimHeader}/report-irr9130', [ClaimInsuranceController::class, 'report'])->name('claim-insurance.get-report-irr9130');
    // IRP0011
    Route::get('claim-accounting', [ClaimAccountingController::class, 'index'])->name('claim-accounting.index');
    Route::get('claim-accounting/{claimHeader}', [ClaimAccountingController::class, 'edit'])->name('claim-accounting.edit');
    Route::get('claim-accounting/{claimHeader}/report-irr9140', [ClaimAccountingController::class, 'report'])->name('claim-accounting.get-report-irr9140');

    Route::get('confirm-to-ap', [ConfirmToAPController::class, 'index'])->name('confirm-to-ap.index');
    Route::get('confirm-to-gl', [ConfirmToGLController::class, 'index'])->name('confirm-to-gl.index');
    Route::get('confirm-to-ar', [ConfirmToARController::class, 'index'])->name('confirm-to-ar.index');

    Route::get('reports/export', [ReportsController::class, 'export'])->name('report.export');
    Route::get('reports', [ReportsController::class, 'index'])->name('report.index');
    Route::get('reports/get-param', [ReportsController::class, 'getParam'])->name('report.get-param');

    //IRR0005-3
    Route::get('reports/get-group-code', [IRR0005_3Controller::class, 'getGroupCode'])->name('report.get-group-code');
    Route::get('reports/get-car-insurance', [IRR0005_3Controller::class, 'getCarInsurance'])->name('report.get-car-insurance');
    Route::get('reports/get-department', [IRR0005_3Controller::class, 'getDepartment'])->name('report.get-department');
    Route::get('reports/get-department-to', [IRR0005_3Controller::class, 'getDepartmentTo'])->name('report.get-department-to');
    
    //IRR0009-1
    Route::get('reports/irr0009-1-get-group-code', [IRR0009_1Controller::class, 'getGroupCode'])->name('report.irr0009-1-get-group-code');
    Route::get('reports/irr0009-1-get-renew-type', [IRR0009_1Controller::class, 'getRenewType'])->name('report.irr0009-1-get-renew-type');

    //IRR0009-2
    Route::get('reports/irr0009-2-get-group-code', [IRR0009_2Controller::class, 'getGroupCode'])->name('report.irr0009-2-get-group-code');
    Route::get('reports/irr0009-2-get-renew-type', [IRR0009_2Controller::class, 'getRenewType'])->name('report.irr0009-2-get-renew-type');

    //IRR0081-1
    Route::get('reports/irr0081-1-get-policy-set', [IRR0081_1Controller::class, 'getPolicySet'])->name('report.irr0081-1-get-policy-set');

    //IRR0009-3
    Route::get('reports/irr0009-3-get-group-code', [IRR0009_3Controller::class, 'getGroupCode'])->name('report.irr0009-3-get-group-code');
    Route::get('reports/irr0009-3-get-gas-station-type', [IRR0009_3Controller::class, 'getGasStationType'])->name('report.irr0009-3-get-gas-station-type');

    //IRR0081-3
    Route::get('reports/irr0081-3-get-policy-set', [IRR0081_3Controller::class, 'getPolicySet'])->name('report.irr0081-3-get-policy-set');
});