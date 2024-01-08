<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CT\Ajax\AllocateRatioController;
use App\Http\Controllers\CT\Ajax\StdCostController;
use App\Http\Controllers\CT\Ajax\StdCostPaperController;
use App\Http\Controllers\CT\Ajax\StdCostInquiryController;
use App\Http\Controllers\CT\Ajax\OemCostController;
use App\Http\Controllers\CT\Ajax\WorkorderProcessController;

// # ALLOCATE_RATIOS

Route::get('/allocate-ratios/year', [AllocateRatioController::class, 'getYear'])->name('allocate-ratios.year');
Route::get('/allocate-ratios/accounts', [AllocateRatioController::class, 'getAccounts'])->name('allocate-ratios.accounts');
Route::get('/allocate-ratios/targets', [AllocateRatioController::class, 'getTargets'])->name('allocate-ratios.targets');

Route::get('/allocate-ratios/dept-codes', [AllocateRatioController::class, 'getDeptCodes'])->name('allocate-ratios.dept-codes');
Route::get('/allocate-ratios/cost-codes', [AllocateRatioController::class, 'getCostCodes'])->name('allocate-ratios.cost-codes');
Route::get('/allocate-ratios/product-groups', [AllocateRatioController::class, 'getProductGroups'])->name('allocate-ratios.product-groups');
Route::get('/allocate-ratios/target-accounts', [AllocateRatioController::class, 'getTargetAccounts'])->name('allocate-ratios.target-accounts');
Route::get('/allocate-ratios/target-dept-codes', [AllocateRatioController::class, 'getTargetDeptCodes'])->name('allocate-ratios.target-dept-codes');
Route::get('/allocate-ratios/target-cost-codes', [AllocateRatioController::class, 'getTargetCostCodes'])->name('allocate-ratios.target-cost-codes');
Route::get('/allocate-ratios/target-product-groups', [AllocateRatioController::class, 'getTargetProductGroups'])->name('allocate-ratios.target-product-groups');

Route::post('/allocate-ratios/year', [AllocateRatioController::class, 'storeYear'])->name('allocate-ratios.year');
Route::post('/allocate-ratios/account', [AllocateRatioController::class, 'storeAccount'])->name('allocate-ratios.account');
Route::post('/allocate-ratios/accounts', [AllocateRatioController::class, 'storeAccounts'])->name('allocate-ratios.accounts');
Route::post('/allocate-ratios/delete-account', [AllocateRatioController::class, 'deleteAccount'])->name('allocate-ratios.delete-account');
Route::post('/allocate-ratios/delete-all-accounts', [AllocateRatioController::class, 'deleteAllAccounts'])->name('allocate-ratios.delete-all-accounts');
Route::post('/allocate-ratios/target', [AllocateRatioController::class, 'storeTarget'])->name('allocate-ratios.target');
Route::post('/allocate-ratios/targets', [AllocateRatioController::class, 'storeTargets'])->name('allocate-ratios.targets');
Route::post('/allocate-ratios/update-targets', [AllocateRatioController::class, 'updateTargets'])->name('allocate-ratios.update-targets');
Route::post('/allocate-ratios/create-new-version', [AllocateRatioController::class, 'createNewVersion'])->name('allocate-ratios.create-new-version');
Route::post('/allocate-ratios/copy-new-version', [AllocateRatioController::class, 'copyNewVersion'])->name('allocate-ratios.copy-new-version');

// # STD_COST
Route::get('/std-costs/year', [StdCostController::class, 'getYear'])->name('std-costs.year');
Route::get('/std-costs/list-years', [StdCostController::class, 'getListYears'])->name('std-costs.list-years');
Route::get('/std-costs/accounts', [StdCostController::class, 'getAccounts'])->name('std-costs.accounts');
Route::get('/std-costs/targets', [StdCostController::class, 'getTargets'])->name('std-costs.targets');
Route::get('/std-costs/list-periods', [StdCostController::class, 'getListPeriods'])->name('std-costs.list-periods');
Route::get('/std-costs/list-prdgrps', [StdCostController::class, 'getListPrdgrps'])->name('std-costs.list-prdgrps');
Route::get('/std-costs/allocate-group-codes', [StdCostController::class, 'getAllocateGroupCodes'])->name('std-costs.allocate-group-codes');
Route::get('/std-costs/allocate-accounts', [StdCostController::class, 'getAllocateAccounts'])->name('std-costs.allocate-accounts');
Route::post('/std-costs/year', [StdCostController::class, 'storeYear'])->name('std-costs.year');
// Route::post('/std-costs/generate-account-targets', [StdCostController::class, 'generateAccountTargets'])->name('std-costs.generate-account-targets');
Route::post('/std-costs/account', [StdCostController::class, 'updateAccount'])->name('std-costs.account');
Route::post('/std-costs/account-expense', [StdCostController::class, 'updateAccountExpense'])->name('std-costs.account-expense');
Route::post('/std-costs/export', [StdCostController::class, 'export'])->name('std-costs.export');

// # STD_COST - PAPER
Route::get('/std-cost-papers/accounts', [StdCostPaperController::class, 'getAccounts'])->name('std-cost-papers.accounts');
Route::get('/std-cost-papers/account-targets', [StdCostPaperController::class, 'getAccountTargets'])->name('std-cost-papers.account-targets');
Route::get('/std-cost-papers/account-targets/tg-prd-groups', [StdCostPaperController::class, 'getAccountTargetTgPrdGroups'])->name('std-cost-papers.account-targets.tg-prd-groups');
Route::get('/std-cost-papers/account-targets/tg-items', [StdCostPaperController::class, 'getAccountTargetTgItems'])->name('std-cost-papers.account-targets.tg-items');
Route::get('/std-cost-papers/summary-prd-groups', [StdCostPaperController::class, 'getSummaryPrdGroups'])->name('std-cost-papers.summary-prd-groups');
Route::get('/std-cost-papers/summary-prd-group-inv-items', [StdCostPaperController::class, 'getSummaryPrdGroupInvItems'])->name('std-cost-papers.summary-prd-group-inv-items');
Route::post('/std-cost-papers/active-new-item', [StdCostPaperController::class, 'updateActiveNewItem'])->name('std-cost-papers.active-new-item');
Route::post('/std-cost-papers/approved-status', [StdCostPaperController::class, 'updateApprovedStatus'])->name('std-cost-papers.approved-status');
Route::post('/std-cost-papers/get-std-cost-data', [StdCostPaperController::class, 'getStdCostData'])->name('std-cost-papers.get-stdcost-data');

// # STD_COST - INQUIRY
Route::get('/std-cost-inquiries/get-inquiries', [StdCostInquiryController::class, 'getInquiries'])->name('std-cost-inquiries.get-inquiries');
Route::get('/std-cost-inquiries/list-versions', [StdCostInquiryController::class, 'getListVersions'])->name('std-cost-inquiries.list-versions');
Route::get('/std-cost-inquiries/list-cost-codes', [StdCostInquiryController::class, 'getListCostCodes'])->name('std-cost-inquiries.list-cost-codes');
Route::get('/std-cost-inquiries/list-inventory-items', [StdCostInquiryController::class, 'getListInventoryItems'])->name('std-cost-inquiries.list-inventory-items');

// # OEM_COST
Route::get('/oem-costs/header', [OemCostController::class, 'getHeader'])->name('oem-costs.header');
Route::get('/oem-costs/list-headers', [OemCostController::class, 'getListHeaders'])->name('oem-costs.list-headers');
Route::get('/oem-costs/lines', [OemCostController::class, 'getLines'])->name('oem-costs.lines');
// Route::get('/oem-costs/list-prdgrps', [OemCostController::class, 'getListPrdgrps'])->name('oem-costs.list-prdgrps');
Route::post('/oem-costs/header', [OemCostController::class, 'storeHeader'])->name('oem-costs.year');
Route::post('/oem-costs/line', [OemCostController::class, 'storeLine'])->name('oem-costs.line');
Route::post('/oem-costs/delete-line', [OemCostController::class, 'deleteLine'])->name('oem-costs.delete-line');
Route::post('/oem-costs/transfer', [OemCostController::class, 'transfer'])->name('oem-costs.transfer');
Route::post('/oem-costs/cancel-transfer', [OemCostController::class, 'cancelTransfer'])->name('oem-costs.cancel-transfer');

// # WORKORDER_PROCESSES
Route::get('/workorders/processes/get-period-numbers', [WorkorderProcessController::class, 'getPeriodNumbers'])->name('workorders.processes.get-period-numbers');
Route::get('/workorders/processes/get-cost-departments', [WorkorderProcessController::class, 'getCostDepartments'])->name('workorders.processes.get-cost-departments');
Route::get('/workorders/processes/get-batch-numbers', [WorkorderProcessController::class, 'getBatchNumbers'])->name('workorders.processes.get-batch-numbers');
Route::get('/workorders/processes/get-trans', [WorkorderProcessController::class, 'getTrans'])->name('workorders.processes.get-trans');
Route::post('/workorders/processes/generate-trans', [WorkorderProcessController::class, 'generateTrans'])->name('workorders.processes.generate-trans');
Route::post('/workorders/processes/query-trans', [WorkorderProcessController::class, 'queryTrans'])->name('workorders.processes.query-trans');
Route::post('/workorders/processes/process-trans', [WorkorderProcessController::class, 'processTrans'])->name('workorders.processes.process-trans');
Route::post('/workorders/processes/store-processes', [WorkorderProcessController::class, 'storeProcesses'])->name('workorders.processes.store-processes');