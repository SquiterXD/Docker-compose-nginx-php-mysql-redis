<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EAM\WorkRequestController;
use App\Http\Controllers\EAM\WorkOrderController;
use App\Http\Controllers\EAM\TransactionController;
use App\Http\Controllers\EAM\Ajax\LovController;
use App\Http\Controllers\EAM\SetupController;
use App\Http\Controllers\EAM\Ajax\SetupController as AjaxSetup;
use App\Http\Controllers\EAM\ReportController;
use App\Http\Controllers\EAM\AskForInformationController;
use App\Http\Controllers\EAM\Ajax\WorkRequestController as AjaxWorkRequest;
use App\Http\Controllers\EAM\Ajax\WorkOrderController as AjaxWorkOrder;
use App\Http\Controllers\EAM\Ajax\CheckOnHandController as AjaxCheckOnHand;
use App\Http\Controllers\EAM\Ajax\ResourceAssetController as AjaxResourceAsset;
use App\Http\Controllers\EAM\Ajax\CheckTransactionController as AjaxCheckTransaction;
use App\Http\Controllers\EAM\Ajax\BillMaterialsController as AjaxBillMaterials;
use App\Http\Controllers\EAM\Ajax\ReportController as AjaxReport;

use App\Http\Controllers\EAM\Ajax\PMPlanController as AjaxPlan;
use App\Http\Controllers\EAM\Reports\EMP0003Controller;

use App\Http\Controllers\EAM\NotificationController;
use App\Http\Controllers\EAM\Ajax\NotificationController as AjaxNotificationController;

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

Route::namespace('e')->prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('lov')->name('lov.')->group(function () {
        Route::get('/assetnumber', [LovController::class, 'assetNumber'])->name('asset-number');
        Route::get('/assetv/assetnumber', [LovController::class, 'assetVAssetNumber'])->name('asset-v-asset-number');
        Route::get('/child-assetnumber/{p_parent}', [LovController::class, 'childAssetNumber'])->name('child-asset-number');
        Route::get('/departments', [LovController::class, 'departments'])->name('departments');
        Route::get('/work-request-status', [LovController::class, 'workRequestStatus'])->name('work-request-status');
        Route::get('/work-receipt-status', [LovController::class, 'workReceiptStatus'])->name('work-receipt-status');
        Route::get('/work-receipt-status/{p_search}', [LovController::class, 'workReceiptStatus'])->name('work-receipt-status');
        Route::get('/employee', [LovController::class, 'employee'])->name('employee');
        Route::get('/work-request-type', [LovController::class, 'workRequestType'])->name('work-request-type');
        Route::get('/activity-priority', [LovController::class, 'activityPriority'])->name('activity-priority');
        Route::get('/work-request-number', [LovController::class, 'workRequestView'])->name('work-request-number');
        Route::get('/workorderhvid', [LovController::class, 'workOrderHVId'])->name('work-order-h-id');
        Route::get('/workorderopnumseq', [LovController::class, 'WorkOrderOpVseqnum'])->name('work-order-op-numseq');
        Route::get('/wipclass', [LovController::class, 'wipClass'])->name('wip-class');
        Route::get('/dep-resource', [LovController::class, 'depResource'])->name('dep-resource');
        Route::get('/status-yn', [LovController::class, 'statusYN'])->name('status-yn');
        Route::get('/item-inventory', [LovController::class, 'ItemInventory'])->name('item-inventory');
        Route::get('/item-nonstock', [LovController::class, 'ItemNonstock'])->name('item-nonstock');
        Route::get('/item-nonstock-mtv', [LovController::class, 'ItemNonstockMtv'])->name('item-nonstock-mtv');
        Route::get('/material-type', [LovController::class, 'MaterialType'])->name('material-type');
        Route::get('/subinventory', [LovController::class, 'Suvinventory'])->name('suvinventory');
        Route::get('/locatorv', [LovController::class, 'LocatorV'])->name('locatorv');
        Route::get('/assetactivity', [LovController::class, 'AssetActivity'])->name('asset-activity');
        Route::get('/issue', [LovController::class, 'Issue'])->name('issue');
        Route::get('/work-order-status', [LovController::class, 'workOrderStatus'])->name('work-order-status');
        Route::get('/work-order-type', [LovController::class, 'workOrderType'])->name('work-order-type');
        Route::get('/shutdown-type', [LovController::class, 'ShutdownType'])->name('shutdown-type');
        Route::get('/workorderrenumseq', [LovController::class, 'WorkOrderReVseqnum'])->name('work-order-re-numseq');
        Route::get('/workorderreresource', [LovController::class, 'WorkOrderReVResource'])->name('work-order-re-resource');
        Route::get('/area', [LovController::class, 'area'])->name('area');
        Route::get('/resource-asset-number', [LovController::class, 'assetVNumber'])->name('resource-asset-number');
        Route::get('/asset-group', [LovController::class, 'assetGroup'])->name('asset-group');
        Route::get('/production-organization', [LovController::class, 'productionOrganization'])->name('production-organization');
        Route::get('/usage-uom', [LovController::class, 'usageUom'])->name('usage-uom');
        Route::get('/resource-asset-locator', [LovController::class, 'resAssetLocator'])->name('resource-asset-locator');
        Route::get('/operation', [LovController::class, 'operation'])->name('operation');
        Route::get('/machine-type', [LovController::class, 'machineType'])->name('machine-type');
        Route::get('/period-year', [LovController::class, 'periodYear'])->name('period-year');
        Route::get('/activity', [LovController::class, 'activity'])->name('activity');
        Route::get('/wo-mt-lot', [LovController::class, 'woMtLot'])->name('wo-mt-lot');
        Route::get('/organization', [LovController::class, 'organization'])->name('organization');
        Route::get('/department-resources', [LovController::class, 'departmentResourcesV'])->name('department-resources');
        Route::get('/asset-resources', [LovController::class, 'assetVResource'])->name('asset-resources');
        Route::get('/request-equip-no', [LovController::class, 'requestEquipNo'])->name('request-equip-no');
        Route::get('/request-status', [LovController::class, 'requestStatus'])->name('request-status');
        Route::get('/period-name', [LovController::class, 'periodName'])->name('period-name');
        Route::get('/resource', [LovController::class, 'resourceV'])->name('resource');
        Route::get('/jobstatus', [LovController::class, 'jobStatusV'])->name('job-status');
        Route::get('/resource-employee', [LovController::class, 'resourceEmployeeV'])->name('resource-employee');
        Route::get('/department-employee', [LovController::class, 'departmentEmployeeV'])->name('department-employee');
        Route::get('/web-user', [LovController::class, 'webUserV'])->name('web-user');
        Route::get('/ptw-users', [LovController::class, 'ptwUsers'])->name('ptw-user');
        Route::get('/fa-asset', [LovController::class, 'faAssetV'])->name('fa-asset');
        Route::get('/reasons', [LovController::class, 'reasonsV'])->name('reasons');
        Route::get('/subinventory-workorder', [LovController::class, 'Subinventory_WorkOrder'])->name('subinventory-workorder');
        Route::get('/get-subinventory', [LovController::class, 'getSubinventory'])->name('get-subinventory');
        Route::get('/get-locator', [LovController::class, 'getLocator'])->name('get-locator');
        Route::get('/request-status-list', [LovController::class, 'requestStatusList'])->name('request-status-list');
        Route::get('/get-check-on-hand-machine01', [LovController::class, 'getCheckOnHandMachine01'])->name('get-check-on-hand-machine01');
        Route::get('/get-check-on-hand-machine02', [LovController::class, 'getCheckOnHandMachine02'])->name('get-check-on-hand-machine02');
        Route::get('/get-requestMatNon', [LovController::class, 'getRequestMatNon'])->name('get-requestMatNon');
        Route::get('/get-organization', [LovController::class, 'getOrganization'])->name('get-organization');
    });

    Route::prefix('work-requests')->name('work-requests.')->group(function () {
        Route::get('/permission-approve', [AjaxWorkRequest::class, 'checkPermissionApprove'])->name('permission-approve');
        Route::get('/cancel/{p_work_request_number}', [AjaxWorkRequest::class, 'cancel'])->name('cancel');
        Route::get('/cancel-approval/{p_work_request_number}', [AjaxWorkRequest::class, 'cancelApproval'])->name('cancel-approval');
        Route::get('/awaiting-work-order/{p_work_request_number}', [AjaxWorkRequest::class, 'awaitingWorkOrderWorkRequests'])->name('awaiting-work-order');
        Route::get('/rejected/{p_work_request_number}', [AjaxWorkRequest::class, 'rejecteWorkRequests'])->name('rejected');
        Route::post('/', [AjaxWorkRequest::class, 'store'])->name('store');
        Route::match(['put', 'patch'], '/status', [AjaxWorkRequest::class, 'updateStatus'])->name('update-status');
        Route::get('/report', [AjaxWorkRequest::class, 'report'])->name('report');
        Route::get('/send-approve/{p_work_request_id}', [AjaxWorkRequest::class, 'sendApprove'])->name('send-approve');
        Route::post('/search', [AjaxWorkRequest::class, 'search'])->name('search');
        Route::post('/search-hierarchy', [AjaxWorkRequest::class, 'searchWithHierarchyV'])->name('search-hierarchy');
        Route::prefix('images')->name('images.')->group(function () {
            Route::get('/{p_work_request_id}', [AjaxWorkRequest::class, 'images'])->name('index');
            Route::post('/{p_work_request_id}', [AjaxWorkRequest::class, 'uploadImage'])->name('upload');
            Route::delete('/{p_attachment_id}', [AjaxWorkRequest::class, 'deleteImage'])->name('delete');
            Route::get('show/{p_attachment_id}', [AjaxWorkRequest::class, 'showImage'])->name('show');
        });
        Route::get('/{p_work_request_number}', [AjaxWorkRequest::class, 'show'])->name('show');
    });

    /*
	 eam0001
	*/
    Route::prefix('check-on-hand')->name('check-on-hand.')->group(function () {
        Route::get('/search', [AjaxCheckOnHand::class, 'search'])->name('search');
        Route::get('images/{p_item_code}', [AjaxCheckOnHand::class, 'images'])->name('images');
        Route::post('image/{p_item_code}', [AjaxCheckOnHand::class, 'uploadImage'])->name('image.upload');
        Route::delete('image/{p_attachment_id}', [AjaxCheckOnHand::class, 'deleteImage'])->name('image.delete');
        Route::get('image/{p_attachment_id}', [AjaxCheckOnHand::class, 'showImage'])->name('image.show');
    });

    /*
	 eam0002
	*/
    Route::prefix('check-transaction')->name('check-transaction.')->group(function () {
        Route::get('/search', [AjaxCheckTransaction::class, 'search'])->name('search');
    });

    /*
	 eam0003
	*/
    Route::prefix('resource-asset')->name('resource-asset.')->group(function () {
        Route::get('/show/{p_asset_number}', [AjaxResourceAsset::class, 'show'])->name('show');
        Route::post('/save', [AjaxResourceAsset::class, 'store'])->name('store');
        Route::get('/asset-category', [AjaxResourceAsset::class, 'assetCategory'])->name('asset-category');
        Route::get('/asset-category/sub-group', [AjaxResourceAsset::class, 'assetCategorySubGroup'])->name('asset-category-subgroup');
        Route::get('/asset-category/sub-machine', [AjaxResourceAsset::class, 'assetCategorySubMachine'])->name('asset-category-submachine');
    });


    /*
    eam10 11 12
    */
    Route::prefix('work-order')->name('work-order.')->group(function () {
        Route::get('/head', [AjaxWorkOrder::class, 'headSearch'])->name('head.index');
        Route::get('/head/show/{p_wip_entity_name}', [AjaxWorkOrder::class, 'headShow'])->name('head.show');
        Route::post('/head/save', [AjaxWorkOrder::class, 'headStore'])->name('head.store');
        Route::post('/head/delete', [AjaxWorkOrder::class, 'headDelete'])->name('head.delete');
        Route::post('/head/unclose', [AjaxWorkOrder::class, 'headUnclose'])->name('head.unclose');
        Route::get('/head/waiting-confirm', [AjaxWorkOrder::class, 'waitingConfirm'])->name('head.waiting-confirm');
        Route::match(['put', 'patch'], '/head/status', [AjaxWorkOrder::class, 'closeAndUncompleteWorkOrder'])->name('head.update-status');
        Route::get('/head/close-jp/{p_wip_entity_name}', [AjaxWorkOrder::class, 'closeJP'])->name('head.close-jp');
        Route::get('/op/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'opAll'])->name('op.all');
        Route::post('/op/save', [AjaxWorkOrder::class, 'opStore'])->name('op.store');
        Route::post('/op/delete', [AjaxWorkOrder::class, 'opDelete'])->name('op.delete');
        Route::get('/re/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'reAll'])->name('re.all');
        Route::get('/report', [AjaxWorkOrder::class, 'report'])->name('report');
        Route::get('/report-part', [AjaxWorkOrder::class, 'reportPart'])->name('report.part');
        Route::post('/re/save', [AjaxWorkOrder::class, 'reStore'])->name('re.store');
        Route::post('/re/delete', [AjaxWorkOrder::class, 'reDelete'])->name('re.delete');

        Route::get('/mt/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'mtAll'])->name('mt.all');
        Route::get('/mt-nonstock/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'mtDirectAll'])->name('mtdirect.all');
        Route::post('/mt/save', [AjaxWorkOrder::class, 'mtStore'])->name('mt.store');
        Route::post('/mt-nonstock/save', [AjaxWorkOrder::class, 'mtDirectStore'])->name('mtdirect.store');
        Route::post('/mt/delete', [AjaxWorkOrder::class, 'mtDelete'])->name('mt.delete');
        Route::post('/mt-nonstock/delete', [AjaxWorkOrder::class, 'mtDirectDelete'])->name('mtdirect.delete');
        Route::post('/mt-nonstock/delete-pr', [AjaxWorkOrder::class, 'mtDirectDeletePr'])->name('mtdirectpr.delete');
        Route::post('/mt/return', [AjaxWorkOrder::class, 'mtReturn'])->name('mt.return');
        Route::post('/mt/issue', [AjaxWorkOrder::class, 'mtIssue'])->name('mt.issue');
        //เซ็คตัดใช้ผ่านระบบ WMS
        Route::post('/mt-check-cut-through-wms', [AjaxWorkOrder::class, 'mtCheckCutThroughWMS'])->name('mtCheckCutThroughWMS');
        //แสดงรายการคืนอะไหล่
        Route::post('/mt-show-re-material', [AjaxWorkOrder::class, 'mtShowReMaterial'])->name('mtShowReMaterial');

        Route::get('/lb/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'lbAll'])->name('lb.all');
        Route::post('/lb/submit', [AjaxWorkOrder::class, 'lbSubmit'])->name('lb.submit');
        Route::post('/lb/save', [AjaxWorkOrder::class, 'lbStore'])->name('lb.store');
        Route::post('/lb/delete', [AjaxWorkOrder::class, 'lbDelete'])->name('lb.delete');
        Route::post('/lb/cancel', [AjaxWorkOrder::class, 'lbCancel'])->name('lb.cancel');
        Route::get('/cp/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'cpAll'])->name('cp.all');
        Route::post('/cp/save', [AjaxWorkOrder::class, 'cpStore'])->name('cp.store');
        Route::get('/cost/all/{p_wip_entity_id}', [AjaxWorkOrder::class, 'costAll'])->name('cost.all');
        Route::get('/item-cost', [AjaxWorkOrder::class, 'getItemCost'])->name('itemcost.get');
        Route::get('/item-onhand', [AjaxWorkOrder::class, 'getItemOnhand'])->name('itemonhand.get');
        Route::get('/defaultwipclass', [AjaxWorkOrder::class, 'defaultWipClass'])->name('default-wip-class');
        Route::get('/auto-class-EMP0007', [AjaxWorkOrder::class, 'autoClassEMP0007'])->name('auto-class-EMP0007');

        Route::get('/check-confirm-mt/{wipEntityName}', [AjaxWorkOrder::class, 'checkConfirmMt'])->name('check-confirm-mt');

        Route::prefix('report')->name('report.')->group(function () {
            Route::get('summary-month', [AjaxWorkOrder::class, 'reportSummaryMonth'])->name('summary-month');
            Route::get('summary-month-excel', [AjaxWorkOrder::class, 'exportSummaryMonth'])->name('summary-month-excel');
            Route::get('payable', [AjaxWorkOrder::class, 'reportPayable'])->name('payable');
            Route::get('close-wo-jp', [AjaxWorkOrder::class, 'reportCloseWoJp'])->name('close-wo-jp');
            Route::get('mnt-history', [AjaxWorkOrder::class, 'reportMntHistory'])->name('mnt-history');
            Route::get('maintenance-excel', [AjaxWorkOrder::class, 'reportMaintenance'])->name('maintenance-excel');
            Route::get('purchase-excel', [AjaxWorkOrder::class, 'reportPurchase'])->name('purchase-excel');
            Route::get('job-account', [AjaxWorkOrder::class, 'reportJobAccount'])->name('job-account');
            Route::get('labor-account', [AjaxWorkOrder::class, 'reportLaborAccount'])->name('labor-account');
            Route::get('wo-cost', [AjaxWorkOrder::class, 'reportWoCost'])->name('wo-cost');
            Route::get('labor-excel', [AjaxWorkOrder::class, 'reportLabor'])->name('labor-excel');
            Route::get('summary-labor', [AjaxWorkOrder::class, 'reportSummaryLabor'])->name('summary-labor');
            Route::get('receipt-mat', [AjaxWorkOrder::class, 'reportReceiptMat'])->name('receipt-mat');
        });
    });

    /*
    eam0006
    */
    Route::prefix('plan')->name('plan.')->group(function () {
        Route::get('/version_plan/{p_year}', [AjaxPlan::class, 'listVersionPlan'])->name('version-plan');
        Route::put('/confirm/{p_plan_id}', [AjaxPlan::class, 'confirm'])->name('confirm');
        Route::post('/', [AjaxPlan::class, 'store'])->name('store');
        Route::get('/{p_year}/{p_version}', [AjaxPlan::class, 'search'])->name('search');
        Route::post('/work-order', [AjaxPlan::class, 'openWorkOrder'])->name('open-work-order');
        Route::delete('/line/{p_plan_id}/', [AjaxPlan::class, 'deleteLine'])->name('delete-line');
        Route::post('file-import', [AjaxPlan::class, 'fileImport'])->name('file-import');
        Route::post('/reservation-version', [AjaxPlan::class, 'reservationVersion'])->name('reservation-version');
    });

    Route::prefix('bill-materials')->name('bill-materials.')->group(function () {
        Route::get('/', [AjaxBillMaterials::class, 'show'])->name('show');
        Route::post('/', [AjaxBillMaterials::class, 'store'])->name('store');
        Route::delete('/', [AjaxBillMaterials::class, 'deleteLine'])->name('delete-line');
        Route::get('/report', [AjaxBillMaterials::class, 'report'])->name('report');
        Route::put('/{request_equip_h_id}/confirm', [AjaxBillMaterials::class, 'confirm'])->name('confirm');
        Route::put('/{request_equip_h_id}/cancel', [AjaxBillMaterials::class, 'cancel'])->name('cancel');
    });

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/issue-mat-excel', [AjaxReport::class, 'exportSummaryMonth'])->name('issue-mat-excel');
        Route::get('/closed-wo', [AjaxReport::class, 'closedWorkOrder'])->name('closed-wo');
        Route::get('/closed-wo2', [AjaxReport::class, 'closedWorkOrder2'])->name('closed-wo2');
        Route::get('/job-account-del', [AjaxReport::class, 'jobAccountDel'])->name('job-account-del');
        Route::get('/request-mat-inv', [AjaxReport::class, 'requestMatInv'])->name('request-mat-inv');
        Route::get('/request-mat-non', [AjaxReport::class, 'requestMatNon'])->name('request-mat-non');
        Route::get('/wo-com-status', [AjaxReport::class, 'woComStatus'])->name('wo-com-status');
        Route::get('/summary-mat-status', [AjaxReport::class, 'summaryMatStatus'])->name('summary-mat-status');
    });

    Route::prefix('notification')->name('notification.')->group(function () {
        Route::post('/setDataMaintenancePending', [AjaxNotificationController::class, 'setDataMaintenancePending'])->name('setDataMaintenancePending');
        Route::post('/searchTableMaintenancePending', [AjaxNotificationController::class, 'searchTableMaintenancePending'])->name('searchTableMaintenancePending');
        Route::post('/setDataMaintenanceSucceed', [AjaxNotificationController::class, 'setDataMaintenanceSucceed'])->name('setDataMaintenanceSucceed');
        Route::post('/setDataOpenJobPending', [AjaxNotificationController::class, 'setDataOpenJobPending'])->name('setDataOpenJobPending');
        Route::post('/setDataOpenJobSucceed', [AjaxNotificationController::class, 'setDataOpenJobSucceed'])->name('setDataOpenJobSucceed');
        Route::post('/setDataCloseJobPending', [AjaxNotificationController::class, 'setDataCloseJobPending'])->name('setDataCloseJobPending');
        Route::post('/setDataCloseJobSucceed', [AjaxNotificationController::class, 'setDataCloseJobSucceed'])->name('setDataCloseJobSucceed');
        Route::post('/searchTableOpenJobPending', [AjaxNotificationController::class, 'searchTableOpenJobPending'])->name('searchTableOpenJobPending');
        Route::post('/searchTableCloseJobPending', [AjaxNotificationController::class, 'searchTableCloseJobPending'])->name('searchTableCloseJobPending');
    });

    Route::prefix('setup')->name('setup.')->group(function () {
        Route::prefix('images')->name('images.')->group(function () {
            Route::get('/{p_asset_id}', [AjaxSetup::class, 'images'])->name('index');
            Route::post('/{p_asset_id}', [AjaxSetup::class, 'uploadImage'])->name('upload');
            Route::delete('/{p_attachment_id}', [AjaxSetup::class, 'deleteImage'])->name('delete');
            Route::get('show/{p_attachment_id}', [AjaxSetup::class, 'showImage'])->name('show');
        });
    });
    
});

Route::prefix('work-requests')->name('work-requests.')->group(function () {
    Route::get('create', [WorkRequestController::class, 'create'])->name('create');
    Route::get('/', [WorkRequestController::class, 'index'])->name('index');
    Route::get('waiting-approve', [WorkRequestController::class, 'waitingApprove'])->name('waiting-approve');
});

Route::prefix('work-orders')->name('work-orders.')->group(function () {
    Route::get('create', [WorkOrderController::class, 'create'])->name('create');
    Route::get('waiting-open-work', [WorkOrderController::class, 'waitingOpenWork'])->name('waiting-open-work');
    Route::get('list-all-repair-jobs', [WorkOrderController::class, 'listAllRepairJobs'])->name('list-all-repair-jobs');
    Route::get('list-repair-jobs-waiting-close', [WorkOrderController::class, 'listRepairJobsWaitingClose'])->name('list-repair-jobs-waiting-close');
    Route::get('confirmed-list-repair-work', [WorkOrderController::class, 'confirmedListRepairWork'])->name('confirmed-list-repair-work');
});

Route::prefix('ask-for-information')->name('ask-for-information.')->group(function () {
    Route::get('parts-transferred-warehouse', [AskForInformationController::class, 'partsTransferredWarehouse'])->name('parts-transferred-warehouse');
    Route::get('check-spare-parts-inventory', [AskForInformationController::class, 'checkSparePartsInventory'])->name('check-spare-parts-inventory');
});

Route::prefix('setup')->name('setup.')->group(function () {
    Route::get('machine', [SetupController::class, 'machine'])->name('machine');
});

Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::get('preventive-maintenance-plan', [TransactionController::class, 'preventiveMaintenancePlan'])->name('preventive-maintenance-plan');
});

Route::prefix('report')->name('report.')->group(function () {
    Route::get('bill-materials', [ReportController::class, 'billMaterials'])->name('bill-materials');
    Route::get('summary-month', [ReportController::class, 'summaryMonth'])->name('summary-month');
    Route::get('summary-month-excel', [ReportController::class, 'summaryMonthExcel'])->name('summary-month-excel');
    Route::get('issue-mat-excel', [ReportController::class, 'issueMatExcel'])->name('issue-mat-excel');
    Route::get('payable', [ReportController::class, 'payable'])->name('payable');
    Route::get('closed-wo', [ReportController::class, 'closedWo'])->name('closed-wo');
    Route::get('closed-wo2', [ReportController::class, 'closedWo2'])->name('closed-wo2');
    Route::get('closed-wo-jp', [ReportController::class, 'closedWoJp'])->name('closed-wo-jp');
    Route::get('mnt-history', [ReportController::class, 'mntHistory'])->name('mnt-history');
    Route::get('maintenance', [ReportController::class, 'maintenance'])->name('maintenance');
    Route::get('job-account-del', [ReportController::class, 'jobAccountDel'])->name('job-account-del');
    Route::get('purchase', [ReportController::class, 'purchase'])->name('purchase');
    Route::get('request-mat-inv', [ReportController::class, 'requestMatInv'])->name('request-mat-inv');
    Route::get('request-mat-non', [ReportController::class, 'requestMatNon'])->name('request-mat-non');
    Route::get('job-account', [ReportController::class, 'jobAccount'])->name('job-account');
    Route::get('labor-account', [ReportController::class, 'laborAccount'])->name('labor-account');
    Route::get('wo-com-status', [ReportController::class, 'woComStatus'])->name('wo-com-status');
    Route::get('labor', [ReportController::class, 'labor'])->name('labor');
    Route::get('wo-cost', [ReportController::class, 'woCost'])->name('wo-cost');
    Route::get('summary-labor', [ReportController::class, 'summaryLabor'])->name('summary-labor');
    Route::get('receipt-mat', [ReportController::class, 'receiptMat'])->name('receipt-mat');
    Route::get('summary-mat-status', [ReportController::class, 'summaryMatStatus'])->name('summary-mat-status');
});
Route::get('/emp0003-excel', [EMP0003Controller::class, 'exportexcel'])->name('emp0003excel');
Route::get('/LovPMreportUser', [LovController::class, 'ptwUsers'])->name('LovPMreportUser');
Route::get('/LovPMreportYear', [LovController::class, 'periodYear2'])->name('LovPMreportYear');
Route::get('/LovPMreportDep', [LovController::class, 'departments2'])->name('LovPMreportDep');

Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');