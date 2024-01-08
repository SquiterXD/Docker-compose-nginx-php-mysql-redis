<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CT\Ajax\CostCenterController AS AjaxCostCenterController;
use App\Http\Controllers\CT\Ajax\CostCenterCategoryController AS AjaxCostCenterCategoryController;
use App\Http\Controllers\CT\Ajax\MeasureController AS AjaxMeasureController;
use App\Http\Controllers\CT\Ajax\OrgInvController AS AjaxOrgInvController;
use App\Http\Controllers\CT\Ajax\CostCenterProductionProcessController AS AjaxCostCenterProductionProcessController;
use App\Http\Controllers\CT\Ajax\ProductGroupController AS AjaxProductGroupController;
use App\Http\Controllers\CT\Ajax\ProductGroupDetailController AS AjaxProductGroupDetailController;
use App\Http\Controllers\CT\Ajax\AccountController AS AjaxAccountController;
use App\Http\Controllers\CT\Ajax\PtglAccountsInfoController AS AjaxPtglAccountsInfoController;
use App\Http\Controllers\CT\Ajax\PtpmItemNumberVController AS AjaxPtpmItemNumberVController;
use App\Http\Controllers\CT\Ajax\PtinvOrganizationsInfoController AS AjaxPtinvOrganizationsInfoController;
use App\Http\Controllers\CT\Ajax\DesignateSetAccountTypeDeptController AS AjaxDesignateSetAccountTypeDeptController;
use App\Http\Controllers\CT\Ajax\SetAccountTypeController AS AjaxSetAccountTypeController;
use App\Http\Controllers\CT\Ajax\SetAccountTypeDeptController AS AjaxSetAccountTypeDeptController;
use App\Http\Controllers\CT\Ajax\AccountCodeLedgerController AS AjaxAccountCodeLedgerController;
use App\Http\Controllers\CT\Ajax\CriterionAllocateController AS AjaxCriterionAllocateController;
use App\Http\Controllers\CT\Ajax\TaxMedicineController AS AjaxTaxMedicineController;
use App\Http\Controllers\CT\Ajax\PtctItemTaxVController AS AjaxPtctItemTaxVController;
use App\Http\Controllers\CT\Ajax\ProductPlanAmountController AS AjaxProductPlanAmountController;
use App\Http\Controllers\CT\Ajax\PurchasePriceInfoController AS AjaxPurchasePriceInfoController;
use App\Http\Controllers\CT\Ajax\StdRawMaterialCostController AS AjaxStdRawMaterialCostController;
use App\Http\Controllers\CT\Ajax\PtctCcGroupVController AS AjaxPtctCcGroupVController;
use App\Http\Controllers\CT\Ajax\PtctAccountTypeVController AS AjaxPtctAccountTypeVController;
use App\Http\Controllers\CT\Ajax\PtYearViewController AS AjaxPtYearViewController;
use App\Http\Controllers\CT\Ajax\ProductGroupPlanController AS AjaxProductGroupPlanController;
use App\Http\Controllers\CT\Ajax\AccountDeptVController AS AjaxAccountDeptVController;
use App\Http\Controllers\CT\Ajax\CostRmController AS AjaxCostRmController;
use App\Http\Controllers\CT\Ajax\GroupingExpenseController AS AjaxGroupingExpenseController;
use App\Http\Controllers\CT\Ajax\StampAdjController AS AjaxStampAdjController;
use App\Http\Controllers\CT\Ajax\RawMaterialInformationController AS AjaxRawMaterialInformationController;
use App\Http\Controllers\CT\Ajax\InquireProductionController AS AjaxInquireProductionController;

use App\Http\Controllers\CT\CostCenterController AS CostCenterController;
use App\Http\Controllers\CT\CostRmController AS CostRmController;
use App\Http\Controllers\CT\ProductGroupController AS ProductGroupController;
use App\Http\Controllers\CT\CriterionAllocateController AS CriterionAllocateController;
use App\Http\Controllers\CT\SetAccountTypeController AS SetAccountTypeController;
use App\Http\Controllers\CT\AccountCodeLedgerController AS AccountCodeLedgerController;
use App\Http\Controllers\CT\SetAccountTypeDeptController AS SetAccountTypeDeptController;
use App\Http\Controllers\CT\TaxMedicineController AS TaxMedicineController;
use App\Http\Controllers\CT\ProductPlanAmountController AS ProductPlanAmountController;
use App\Http\Controllers\CT\PurchasePriceInfoController AS PurchasePriceInfoController;
use App\Http\Controllers\CT\StdRawMaterialCostController AS StdRawMaterialCostController;
use App\Http\Controllers\CT\GroupingExpenseController;
use App\Http\Controllers\CT\StampAdjController;
use App\Http\Controllers\CT\RawMaterialInformationController;
use App\Http\Controllers\CT\InquireProductionController;

Route::get('/my_test_page', function () {
    return view('ct.test.index');
})->name('test');

Route::prefix('cost_center')->name('cost_center.')->group(function () {
    Route::get('/', [CostCenterController::class, 'index'])->name('index');
    Route::get('/create', [CostCenterController::class, 'create'])->name('create');
    Route::get('/{cost_code}', [CostCenterController::class, 'edit'])->name('edit');
  });

Route::prefix('cost_rm')->name('cost_rm.')->group(function () {
  Route::get('/', [CostRmController::class, 'index'])->name('index');
});

Route::get('specify_percentage', [CostCenterController::class, 'specifyPercentage'])->name('specify_percentage.create');
Route::prefix('product_group')->name('product_group.')->group(function () {
    Route::get('/', [ProductGroupController::class, 'index'])->name('index');
    Route::get('/{product_group}', [ProductGroupController::class, 'show'])->name('show');
});
Route::get('criterion_allocate', [CriterionAllocateController::class, 'index'])->name('criterion_allocate.index');
Route::get('set_account_type', [SetAccountTypeController::class, 'index'])->name('set_account_type.index');
Route::get('account_code_ledger', [AccountCodeLedgerController::class, 'index'])->name('account_code_ledger.index');
Route::get('set_account_type_dept/{acc_code}', [SetAccountTypeDeptController::class, 'show'])->name('set_account_type_dept.show');
Route::get('specify_agency', [CostCenterController::class, 'specifySetAccountTypeDept'])->name('specify_agency.index');

Route::prefix('product_plan_amount')->name('product_plan_amount.')->group(function () {
    Route::get('/', [ProductPlanAmountController::class, 'index'])->name('index');
});

Route::prefix('purchase_price_info')->name('purchase_price_info.')->group(function () {
    Route::get('/', [PurchasePriceInfoController::class, 'index'])->name('index');
    Route::get('/import-xls', [PurchasePriceInfoController::class, 'importXls']);
    Route::get('/create', [PurchasePriceInfoController::class, 'create'])->name('create');
});

Route::prefix('tax_medicine')->name('tax_medicine.')->group(function (){
    Route::get('/', [TaxMedicineController::class, 'index'])->name('index');
    Route::get('/create', [TaxMedicineController::class, 'create'])->name('create');
    Route::get('/{tax_medicine}', [TaxMedicineController::class, 'edit'])->name('edit');
});

Route::prefix('std_raw_material_cost')->name('std_raw_material_cost.')->group(function (){
    Route::get('/', [StdRawMaterialCostController::class, 'index'])->name('index');
    Route::get('/create', [StdRawMaterialCostController::class, 'create'])->name('create');
});



Route::get('account_code_ledger/create', [AccountCodeLedgerController::class, 'create'])->name('account_code_ledger.create');
Route::get('account_code_ledger/{id}/edit', [AccountCodeLedgerController::class, 'edit'])->name('account_code_ledger.edit');

Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::get('/account', [AjaxAccountController::class, 'index'])->name('account.index');
    Route::get('/get_data_by_segment/{segment}', [AjaxPtglAccountsInfoController::class, 'getDataBySegment'])->name('ptgl_accounts_info.get_data_by_segment');
    Route::get('/get_category', [AjaxPtpmItemNumberVController::class, 'getCategory'])->name('ptpm_item_number_v.get_category');
    Route::get('/get_organizations', [AjaxPtinvOrganizationsInfoController::class, 'getOrganizations'])->name('ptpm_item_number_v.get_organizations');
    Route::get('/organization_source_item_cost', [AjaxPtinvOrganizationsInfoController::class, 'organizationSourceItemCost'])->name('ptpm_item_number_v.organizationSourceItemCost');
    Route::get('/cost_center_group_v', [AjaxCostCenterController::class, 'costCenterGroupV'])->name('cost_center_group');
    Route::get('/cost_center_category', [AjaxCostCenterCategoryController::class, 'index']);
    Route::get('/measure', [AjaxMeasureController::class, 'index']);
    Route::get('/get_raw_material', [AjaxPtpmItemNumberVController::class, 'getRawMaterial'])->name('ptpm_item_number_v.get_raw_material');
    Route::get('/get_raw_material_tax', [AjaxPtpmItemNumberVController::class, 'getRawMaterialTax'])->name('ptpm_item_number_v.get_raw_material_tax');
    Route::get('/inv_org', [AjaxOrgInvController::class, 'index']);
    Route::get('/org_material', [AjaxOrgInvController::class, 'orgMaterail']);

    Route::prefix('cost_center')->name('cost_center.')->group(function () {
        Route::post('/', [AjaxCostCenterController::class, 'store']);
        Route::get('/', [AjaxCostCenterController::class, 'index'])->name('index');
        Route::get('/inv_org', [AjaxCostCenterController::class, 'invOrg'])->name('inv_org');
        Route::get('uom_v', [AjaxCostCenterController::class, 'uomV'])->name('uom_v');
        Route::post('/package', [AjaxCostCenterController::class, 'storePackage']);
        Route::get('/find', [AjaxCostCenterController::class, 'find'])->name('find');
        Route::post('/update_active', [AjaxCostCenterController::class, 'updateIsActive'])->name('update_active');
        Route::get('/period_years', [AjaxCostCenterController::class, 'getPeriodYearForDropdown'])->name('period_years');
        Route::post('/update_ct', [AjaxCostCenterController::class, 'updateCostCenter'])->name('update_ct');
        Route::post('/update', [AjaxCostCenterController::class, 'update'])->name('update');
        Route::get('/years', [AjaxCostCenterController::class, 'getYearForDropdown'])->name('years');
        Route::get('/codes', [AjaxCostCenterController::class, 'getCodeForDropdown'])->name('codes');
        Route::get('/ptpm_items', [AjaxCostCenterController::class, 'getPtpmItemForDropdown'])->name('ptpm_items');
        Route::get('/cost-center-view', [AjaxCostCenterController::class, 'getCostCenterView'])->name('getCostCenterView');
    });

    Route::prefix('cost_rm')->name('cost_rm.')->group(function () {
      Route::get('/', [AjaxCostRmController::class, 'index'])->name('index');
      Route::post('/', [AjaxCostRmController::class, 'store'])->name('store');
      Route::delete('/', [AjaxCostRmController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('product_group')->name('product_group.')->group(function () {
        Route::get('/', [AjaxProductGroupController::class, 'index'])->name('index');
        Route::get('/find', [AjaxProductGroupController::class, 'find'])->name('find');
        Route::get('/copy/{code}', [AjaxProductGroupController::class, 'copyProductGroup'])->name('copy.get');
        Route::post('/copy', [AjaxProductGroupController::class, 'copy'])->name('copy.post');
        Route::get('/item_costing', [AjaxProductGroupController::class, 'itemCosting'])->name('item_costing');
        Route::delete('/{id}', [AjaxProductGroupController::class, 'delete'])->name('delete');

        Route::get('/get-data-from-view', [AjaxProductGroupController::class, 'getDataFromView'])->name('getDataFromView');
        Route::post('/cost-code', [AjaxProductGroupController::class, 'storeCostCode'])->name('storeCostCode');
        Route::post('/update-cost-code', [AjaxProductGroupController::class, 'updateCostCode'])->name('updateCostCode');
        Route::post('/del-cost-code', [AjaxProductGroupController::class, 'delCostCode'])->name('delCostCode');

        Route::post('/store-product-item', [AjaxProductGroupController::class, 'storeProductItem'])->name('storeProductItem');
        Route::post('/del-product-item', [AjaxProductGroupController::class, 'delProductItem'])->name('delProductItem');


        Route::post('/product-item', [AjaxProductGroupController::class, 'store'])->name('store');

        Route::post('/update', [AjaxProductGroupController::class, 'update'])->name('update');

    });

    Route::prefix('product_group_detail')->name('product_group_detail.')->group(function () {
        Route::get('/lot', [AjaxProductGroupDetailController::class, 'lot'])->name('lot');
        Route::post('/update', [AjaxProductGroupDetailController::class, 'update'])->name('update');
        Route::get('/find_pg/{product_group_id}', [AjaxProductGroupDetailController::class, 'findWithProductGroup'])->name('findWithProductGroup');
    });

    Route::prefix('product_plan_amount')->name('product_plan_amount.')->group(function () {
        Route::post('/update', [AjaxProductPlanAmountController::class, 'update'])->name('update');
        Route::get('/years', [AjaxProductPlanAmountController::class, 'getYearForDropdown'])->name('years');
        Route::get('/period-month/{year}', [AjaxProductPlanAmountController::class, 'getPeriodMonthDropdown'])->name('periodMonth');
    });

    Route::prefix('product_processes')->name('product_processes.')->group(function () {
        Route::put('/', [AjaxCostCenterProductionProcessController::class, 'update'])->name('update');
        Route::get('/{cost_center_id}', [AjaxCostCenterProductionProcessController::class, 'show'])->name('show');
    });

    Route::prefix('designate_agency')->name('designate_agency.')->group(function () {
        Route::get('/get_department', [AjaxDesignateSetAccountTypeDeptController::class, 'getDepartment'])->name('get_department');
    });

    Route::prefix('set_account_type')->name('set_account_type.')->group(function () {
        Route::get('/', [AjaxSetAccountTypeController::class, 'getListSetAccountType'])->name('getListSetAccountType');
        Route::post('update', [AjaxSetAccountTypeController::class, 'update'])->name('update');
    });

    Route::prefix('set_account_type_dept')->name('set_account_type_dept.')->group(function () {
        Route::post('update', [AjaxSetAccountTypeDeptController::class, 'update'])->name('update');
    });

    Route::prefix('account_dept_v')->name('account_dept.')->group(function () {
        Route::get('/', [AjaxAccountDeptVController::class, 'index'])->name('index');
        Route::post('/', [AjaxAccountDeptVController::class, 'store'])->name('store');
        Route::get('/find-dept', [AjaxAccountDeptVController::class, 'findDept'])->name('findDept');
        Route::get('/find-add-account', [AjaxAccountDeptVController::class, 'findAddAccount'])->name('findAddAccount');
        Route::post('/pkg_deptcode', [AjaxAccountDeptVController::class, 'addDeptCode'])->name('addDeptCode');
        Route::post('/update-dept', [AjaxAccountDeptVController::class, 'updateDeptCode'])->name('updateDeptCode');
    });

    Route::prefix('account_code_ledger')->name('account_code_ledger.')->group(function () {
        Route::post('/', [AjaxAccountCodeLedgerController::class, 'store'])->name('store');

        Route::post('update', [AjaxAccountCodeLedgerController::class, 'update'])->name('update');
        Route::get('get-detail', [AjaxAccountCodeLedgerController::class, 'getDetail'])->name('getDetail');
        Route::get('get-product-group', [AjaxAccountCodeLedgerController::class, 'getProductGroup'])->name('getProductGroup');
        Route::get('get-data-list', [AjaxAccountCodeLedgerController::class, 'getDataList'])->name('getDataList');
        Route::get('get-category', [AjaxAccountCodeLedgerController::class, 'getCategory'])->name('getCategory');
        Route::get('get-organizations', [AjaxAccountCodeLedgerController::class, 'getOrganizations'])->name('getOrganizations');
        Route::get('get-data-list-segments', [AjaxAccountCodeLedgerController::class, 'getDataListSegments'])->name('getDataListSegments');
    });

    Route::prefix('criterion_allocate')->name('criterion_allocate.')->group(function () {
        Route::get('/', [AjaxCriterionAllocateController::class, 'index'])->name('index');
        Route::post('update', [AjaxCriterionAllocateController::class, 'update'])->name('update');
    });

    Route::prefix('tax_medicine')->name('tax_medicine.')->group(function () {
        // Route::get('/', [AjaxTaxMedicineController::class, 'index'])->name('index');
        // Route::post('/', [AjaxTaxMedicineController::class, 'store'])->name('store');
        Route::get('determine', [AjaxTaxMedicineController::class, 'determine'])->name('determine');
        Route::get('not_determine', [AjaxTaxMedicineController::class, 'notDetermine'])->name('not_determine');

        // Add new route 19082022
        Route::get('/', [AjaxPtctItemTaxVController::class, 'index'])->name('index');
        Route::post('/', [AjaxPtctItemTaxVController::class, 'store'])->name('store');
        Route::post('delete/{item}', [AjaxPtctItemTaxVController::class, 'destroy'])->name('destroy');

        Route::put('/{item_number}', [AjaxTaxMedicineController::class, 'update'])->name('update');
        Route::get('/{item_number}', [AjaxTaxMedicineController::class, 'show'])->name('show');
    });

    Route::prefix('criterion_allocate')->name('criterion_allocate.')->group(function () {
        Route::get('/', [AjaxCriterionAllocateController::class, 'index'])->name('index');
        Route::post('update', [AjaxCriterionAllocateController::class, 'update'])->name('update');
    });

    Route::prefix('purchase_price_info')->name('purchase_price_info.')->group(function () {
        Route::get('/', [AjaxPurchasePriceInfoController::class, 'index'])->name('index');
        Route::post('/', [AjaxPurchasePriceInfoController::class, 'store'])->name('store');
        Route::get('/version', [AjaxPurchasePriceInfoController::class, 'version'])->name('version');
        Route::put('/line/{std_line_id}', [AjaxPurchasePriceInfoController::class, 'updateLine'])->name('updateLine');
        Route::get('/update_status/{std_head_id}', [AjaxPurchasePriceInfoController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update_import', [AjaxPurchasePriceInfoController::class, 'updateImport'])->name('updateImport');
        Route::post('/check_item_number', [AjaxPurchasePriceInfoController::class, 'checkItemNumber'])->name('checkItemNumber');
        Route::delete('/line/{std_line_id}', [AjaxPurchasePriceInfoController::class, 'deleteLine'])->name('deleteLine');
        Route::delete('/head/{std_head_id}', [AjaxPurchasePriceInfoController::class, 'deleteAll'])->name('deleteAll');
    });

    Route::prefix('std_raw_material_cost')->name('std_raw_material_cost.')->group(function () {
        Route::get('/', [AjaxStdRawMaterialCostController::class, 'index'])->name('index');
        Route::post('/', [AjaxStdRawMaterialCostController::class, 'store'])->name('store');
        Route::post('/date', [AjaxStdRawMaterialCostController::class, 'date'])->name('date');
        Route::get('/plan_version_cost_head', [AjaxStdRawMaterialCostController::class, 'planVersionCostHead'])->name('plan_version_cost_head');
        Route::get('/version', [AjaxStdRawMaterialCostController::class, 'version'])->name('version');
        Route::get('/find', [AjaxStdRawMaterialCostController::class, 'find'])->name('find');
        Route::post('enable_flag', [AjaxStdRawMaterialCostController::class, 'enableFlag'])->name('enable_flag');
        Route::post('/approve', [AjaxStdRawMaterialCostController::class, 'approve'])->name('approve');
        Route::post('/approveLineData', [AjaxStdRawMaterialCostController::class, 'approveLineData'])->name('approveLineData');
        Route::get('/get_version', [AjaxStdRawMaterialCostController::class, 'getVersion'])->name('getVersion');
        Route::get('/get_plan_version', [AjaxStdRawMaterialCostController::class, 'getPlanVersion'])->name('getPlanVersion');
        Route::get('/get_cost_center', [AjaxStdRawMaterialCostController::class, 'getCostCenter'])->name('getCostCenter');
    });

    Route::prefix('account_type')->name('account_type.')->group(function (){
        Route::get('/', [AjaxPtctAccountTypeVController::class, 'index'])->name('index');
    });

    Route::prefix('cc_group')->name('cc_group.')->group(function () {
        Route::get('/', [AjaxPtctCcGroupVController::class, 'index'])->name('index');
    });
    Route::prefix('year-view')->name('year-view.')->group(function () {
        Route::get('/', [AjaxPtYearViewController::class, 'index'])->name('index');
    });
    Route::prefix('product-group-plan')->name('product-group-plan.')->group(function () {
        Route::get('/', [AjaxProductGroupPlanController::class, 'index'])->name('index');
        Route::post('/', [AjaxProductGroupPlanController::class, 'store'])->name('store');
        Route::post('/update-item', [AjaxProductGroupPlanController::class, 'updateItem'])->name('updateItem');
        Route::get('/uom', [AjaxProductGroupPlanController::class, 'uom'])->name('uom');
        Route::get('plan-version', [AjaxProductGroupPlanController::class, 'planVersion'])->name('planVersion');
    });
    Route::prefix('grouping_expense')->name('grouping_expense.')->group(function () {
        Route::post('/', [AjaxGroupingExpenseController::class, 'store'])->name('store');
        Route::get('/get-detail', [AjaxGroupingExpenseController::class, 'getDetail'])->name('getDetail');
        Route::post('/detail', [AjaxGroupingExpenseController::class, 'storeDetail'])->name('storeDetail');
        Route::get('/check-detail', [AjaxGroupingExpenseController::class, 'checkDetail'])->name('checkDetail');
        Route::post('/delete/{header}', [AjaxGroupingExpenseController::class, 'destroy'])->name('destroy');
        Route::post('/delete-detail/{detail}', [AjaxGroupingExpenseController::class, 'destroyDetail'])->name('destroyDetail');
    });

    //CTM0020
    Route::prefix('stamp_adj')->name('stamp_adj.')->group(function () {
        Route::get('/get-setment', [AjaxStampAdjController::class, 'getSetment'])->name('getSetment');
        Route::post('/', [AjaxStampAdjController::class, 'store'])->name('store');
        Route::get('/get-data-list', [AjaxStampAdjController::class, 'getDataList'])->name('getDataList');
        Route::post('/{id}', [AjaxStampAdjController::class, 'update'])->name('update');

        //Stamp Adjust -- W. 20221110
        Route::get('/get-list-month', [AjaxStampAdjController::class, 'getListMonth'])->name('getListMonth');
    });

    // CTP0005
    Route::prefix('stamp-adjust')->name('stamp-adjust.')->group(function (){
        Route::post('/store-process', [AjaxStampAdjController::class, 'storeStampProcess'])->name('storeProcess');
        Route::patch('update/{period}', [AjaxStampAdjController::class, 'updateStampProcess'])->name('updateProcess');
        Route::post('interface-gl', [AjaxStampAdjController::class, 'interfaceGL'])->name('interface_gl');
        Route::post('cancel-interface-gl', [AjaxStampAdjController::class, 'cancelInterfaceGL'])->name('cancel_interface_gl');
        Route::post('manaul-stamp', [AjaxStampAdjController::class, 'manualStamp'])->name('manaul_stamp');
    });

    //CTP002
    Route::prefix('raw_material_information')->name('raw_material_information.')->group(function () {
        Route::get('/', [AjaxRawMaterialInformationController::class, 'index'])->name('index');
        Route::get('/get-lines', [AjaxRawMaterialInformationController::class, 'getLines'])->name('getLines');
    });

    //CTP003
    Route::prefix('inquire_production')->name('inquire_production.')->group(function () {
        Route::get('/', [AjaxInquireProductionController::class, 'index'])->name('index');
        Route::get('/get-period-name', [AjaxInquireProductionController::class, 'getPeriodName'])->name('getPeriodName');
        Route::get('/get-lines', [AjaxInquireProductionController::class, 'getLines'])->name('getLines');
    });

});

//CTM0011
Route::get('grouping_expense', [GroupingExpenseController::class, 'index'])->name('grouping_expense.index');
Route::get('grouping_expense/create', [GroupingExpenseController::class, 'create'])->name('grouping_expense.create');
Route::get('grouping_expense/{id}/edit', [GroupingExpenseController::class, 'edit'])->name('grouping_expense.edit');

//CTM0020
Route::get('stamp_adj', [StampAdjController::class, 'index'])->name('stamp_adj.index');
Route::get('stamp_adj/create', [StampAdjController::class, 'create'])->name('stamp_adj.create');
Route::get('stamp_adj/{id}/edit', [StampAdjController::class, 'edit'])->name('stamp_adj.edit');

//CTP0002
Route::get('raw_material_information', [RawMaterialInformationController::class, 'index'])->name('raw_material_information.index');

//CTP0003
Route::get('inquire_production', [InquireProductionController::class, 'index'])->name('inquire_production.index');

// Stamp Adjust -- Piyawut A. 20221027
// CTP0005
Route::prefix('stamp-adjust')->name('stamp-adjust.')->group(function (){
    Route::get('process', [StampAdjController::class, 'process'])->name('process');
});
