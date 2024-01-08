<?php

use Illuminate\Support\Facades\Route\settings;

use App\Http\Controllers\PM\Settings\MaterialGroupController;
use App\Http\Controllers\PM\Settings\RelationFeederController;
use App\Http\Controllers\PM\Settings\MachineRelationController;

use App\Http\Controllers\PM\Settings\Ajax\OrgTransferController as AjaxOrgTransferController;
use App\Http\Controllers\PM\Settings\OrgTransferController;

use App\Http\Controllers\PM\Settings\WipStepController;
use App\Http\Controllers\PM\Settings\ProductionFormulaController;

use App\Http\Controllers\PM\Settings\SavePublicationLayoutController;
use App\Http\Controllers\PM\Settings\Ajax\SavePublicationLayoutController as AjaxSavePublicationLayoutController;
use App\Http\Controllers\PM\Settings\Ajax\SavePublicationLayouts\ConversionRateController as AjaxConversionRateController;



use App\Http\Controllers\PM\Settings\Ajax\ProductFormulaController;
use App\Http\Controllers\PM\Settings\Ajax\RelationController;

use App\Http\Controllers\PM\Settings\SetupMinMaxByItemController;
use App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController as AjaxSetupMinMaxByItemController;

use App\Http\Controllers\PM\Settings\SetupTransferController;
use App\Http\Controllers\PM\Settings\Ajax\SetupTransferController as AjaxSetupTransferController;

use App\Http\Controllers\PM\Settings\PrintConversionController;
use App\Http\Controllers\PM\Settings\Ajax\PrintConversionController as AjexPrintConversionController;

use App\Http\Controllers\PM\Settings\PrintProductTypeController;
use App\Http\Controllers\PM\Settings\Ajax\PrintProductTypeController as AjexPrintProductTypeController;

use App\Http\Controllers\PM\Settings\MaxStorageController;
use App\Http\Controllers\PM\Settings\Ajax\MaxStorageController as AjexMaxStorageController;

use App\Http\Controllers\PM\Settings\SetupBeforeNoticeController;

use App\Http\Controllers\PM\Settings\PrintMachineGroupController;
use App\Http\Controllers\PM\Settings\Ajax\PrintMachineGroupController as AjaxPrintMachineGroupController;

use App\Http\Controllers\PM\Settings\MachinePowerTempController;
use App\Http\Controllers\PM\Settings\Ajax\MachinePowerTempController as AjaxMachinePowerTempController;

use App\Http\Controllers\PM\Settings\PrintItemSetupController;

use App\Http\Controllers\PM\Settings\CopyProductionFormulaController;

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


Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::get('org-tranfer/get_locations_from', [AjaxOrgTransferController::class, 'getLocationsFrom']);
    Route::get('org-tranfer/get_locations_to', [AjaxOrgTransferController::class, 'getLocationsTo']);    
    Route::get('org-tranfer/get_transaction_types', [AjaxOrgTransferController::class, 'getTransactionTypes']);    
    
    Route::get('get-item-number', [AjexSavePublicationLayoutController::class, 'getItemNumber'])->name('get-item-number');
    Route::get('get-data-table', [AjexSavePublicationLayoutController::class, 'getDataTable'])->name('get-data-table');

    //สูตรการผลิต
    Route::get('get-wip-step', [ProductFormulaController::class, 'getWipStep']);
    Route::get('get-version', [ProductFormulaController::class, 'getVersion']);
    Route::get('get-uom', [ProductFormulaController::class, 'getUom']);
    Route::get('get-item-header', [ProductFormulaController::class, 'getItemHeader']);
    Route::get('get-item', [ProductFormulaController::class, 'getItem']);
    Route::get('get-machine-type', [ProductFormulaController::class, 'getMachineType']);
    Route::get('search-formula', [ProductFormulaController::class, 'searchFormula']);
    Route::get('get-invoice-flag', [ProductFormulaController::class, 'getInvoiceFlag']);

    //ความสัมพันธ์ของชุดเครื่องจักร    
    Route::get('get-asset', [RelationController::class, 'index']);
    Route::get('validate-asset', [RelationController::class, 'validateAsset']);

    //กำหนดค่าเฝ้าระวัง
    Route::get('setup-min-max-by-item/get-organization', [AjaxSetupMinMaxByItemController::class, 'getOrganization'])->name('get-organization');
    Route::get('setup-min-max-by-item/get-locations', [AjaxSetupMinMaxByItemController::class, 'getLocations'])->name('get-locations');
    Route::get('setup-min-max-by-item/get-item-number', [AjaxSetupMinMaxByItemController::class, 'getItemNumber'])->name('get-item-number');
    Route::get('setup-min-max-by-item/get-uom', [AjaxSetupMinMaxByItemController::class, 'getUom'])->name('get-uom');
    Route::get('setup-min-max-by-item/destroy', [AjaxSetupMinMaxByItemController::class, 'destroy'])->name('destroy');
    Route::get('setup-min-max-by-item/search', [AjaxSetupMinMaxByItemController::class, 'search'])->name('search');
    
    //PMS0032 : บันทึกคลังเบิกวัตถุดิบ
    Route::get('setup-transfer/get-organization', [AjaxSetupTransferController::class, 'getOrganization']);
    Route::get('setup-transfer/get-locations', [AjaxSetupTransferController::class, 'getLocations']);
    Route::get('setup-transfer/get-subinventory', [AjaxSetupTransferController::class, 'getSubinventory']);

    //PMS0036 : บันทึกแปลงหน่วยสิ่งพิมพ์
    Route::get('print-conversion/destroy', [AjexPrintConversionController::class, 'destroy'])->name('print-conversion.destroy');
    Route::get('print-conversion/get-printType', [AjexPrintConversionController::class, 'getPrintType'])->name('print-conversion.getPrintType');

    //PMS0039: กำหนด Product ประเภทสิ่งพิมพ์ 
    // Route::get('print-product-type/destroy', [AjexPrintProductTypeController::class, 'destroy'])->name('print-product-type.destroy');

    // PMS0030 กำหนดพื้นที่วางของ
    Route::get('max-storage/get-uom', [AjexMaxStorageController::class, 'getUom'])->name('max-storage.getUom');
    
    // ==================== PMS0023 [ บันทึก Layout สิ่งพิมพ์ ] ====================
    Route::get('save-publication-layout/get-table-results', [AjaxSavePublicationLayoutController::class, 'getTableResults']);
    Route::post('save-publication-layout/update-or-create', [AjaxSavePublicationLayoutController::class, 'updateOrCreate']);
    Route::post('save-publication-layout/store', [AjaxSavePublicationLayoutController::class, 'store']);

    Route::post('print-machine-group/store', [AjaxPrintMachineGroupController::class, 'store']);
    Route::post('print-machine-group/getTableSetup', [AjaxPrintMachineGroupController::class, 'getTableSetup']);

    Route::get('machine-power-temp/getMachine', [AjaxMachinePowerTempController::class, 'getMachine']);
    Route::get('machine-power-temp/getTable', [AjaxMachinePowerTempController::class, 'getTable']);
    Route::post('machine-power-temp/store', [AjaxMachinePowerTempController::class, 'store']);

    Route::group(['prefix' => 'settings/save-publication-layout/conversion-rates', 'as' => 'settings.save-publication-layout.conversion-rates.'], function () {
        Route::get('/', [AjaxConversionRateController::class, 'index'])->name('index');
        Route::post('/', [AjaxConversionRateController::class, 'store'])->name('store');
    });
});

Route::group(['namespace' => 'Settings', 'prefix' => 'settings', 'as' => 'settings.'], function () {

    Route::get('material-group', [MaterialGroupController::class, 'index'])->name('material-group.index');
    Route::get('material-group/create', [MaterialGroupController::class, 'create'])->name('material-group.create');
    Route::post('material-group/store', [MaterialGroupController::class, 'store'])->name('material-group.store');

    Route::get('relation-feeder', [RelationFeederController::class, 'index'])->name('relation-feeder.index');
    Route::get('relation-feeder/create', [RelationFeederController::class, 'create'])->name('relation-feeder.create');
    Route::post('relation-feeder/store', [RelationFeederController::class, 'store'])->name('relation-feeder.store');
    Route::get('relation-feeder/{machnie_group}/{feeder_code}/edit', [RelationFeederController::class, 'edit'])->name('relation-feeder.edit');
    Route::post('relation-feeder/update', [RelationFeederController::class, 'update'])->name('relation-feeder.update');

    Route::get('org-tranfer', [OrgTransferController::class, 'index'])->name('org-tranfer.index');
    Route::get('org-tranfer/create', [OrgTransferController::class, 'create'])->name('org-tranfer.create');  
    Route::post('org-tranfer/store', [OrgTransferController::class, 'store'])->name('org-tranfer.store');    
    Route::get('org-tranfer/edit/{id}', [OrgTransferController::class, 'edit'])->name('org-tranfer.edit');
    Route::post('org-tranfer/update', [OrgTransferController::class, 'update'])->name('org-tranfer.update'); 
    
    //ขั้นตอนการทำงาน <PMS0004>
    Route::get('wip-step', [WipStepController::class, 'index'])->name('wip-step.index');
    Route::get('wip-step/create', [WipStepController::class, 'create'])->name('wip-step.create');
    Route::post('wip-step', [WipStepController::class, 'store'])->name('wip-step.store');
    Route::get('wip-step/{id}/edit', [WipStepController::class, 'edit'])->name('wip-step.edit');
    Route::put('wip-step/{id}', [WipStepController::class, 'update'])->name('wip-step.update');
    Route::get('wip-step/{id}/show', [WipStepController::class, 'show'])->name('wip-step.show');

    //สูตรการผลิต
    Route::get('production-formula', [ProductionFormulaController::class, 'index'])->name('production-formula.index');
    Route::get('production-formula/create', [ProductionFormulaController::class, 'create'])->name('production-formula.create');
    Route::post('production-formula', [ProductionFormulaController::class, 'store'])->name('production-formula.store');
    Route::get('production-formula/{id}/edit', [ProductionFormulaController::class, 'edit'])->name('production-formula.edit');
    Route::put('production-formula/{id}', [ProductionFormulaController::class, 'update'])->name('production-formula.update');
    Route::get('production-formula/{id}/show', [ProductionFormulaController::class, 'show'])->name('production-formula.show');
    Route::post('production-formula/copy/{id}', [ProductionFormulaController::class, 'copy'])->name('production-formula.copy');
    Route::get('production-formula/{id}/approve', [ProductionFormulaController::class, 'approve'])->name('production-formula.approve');
    Route::get('production-formula/{id}/inactive', [ProductionFormulaController::class, 'inactive'])->name('production-formula.inactive');
    Route::get('production-formula/{id}/active', [ProductionFormulaController::class, 'active'])->name('production-formula.active');

    // PMS0033.1 คัดลอกสูตรมาตราฐานทั้งหมด
    Route::get('copy-production-formula', [CopyProductionFormulaController::class, 'index'])->name('copy-production-formula.index');
    Route::get('copy-production-formula/copy', [CopyProductionFormulaController::class, 'copyFormula'])->name('copy-production-formula.copy');
    Route::get('copy-production-formula/export', [CopyProductionFormulaController::class, 'Export'])->name('copy-production-formula.export');

    // ==================== PMS0023 [ บันทึก Layout สิ่งพิมพ์ ] ====================
    Route::get('save-publication-layout', [SavePublicationLayoutController::class, 'index'])->name('save-publication-layout.index');
    // Route::post('save-publication-layout/store', [SavePublicationLayoutController::class, 'store'])->name('save-publication-layout.store');
    Route::get('save-publication-layout/{id}/edit', [SavePublicationLayoutController::class, 'edit'])->name('save-publication-layout.edit');
    Route::put('save-publication-layout/update', [SavePublicationLayoutController::class, 'update'])->name('save-publication-layout.update');

    //PMS0028 ความสัมพันธ์ของชุดเครื่องจักร
    Route::get('machine-relation',           [MachineRelationController::class, 'index'])->name('machine-relation.index');
    Route::get('machine-relation/create',    [MachineRelationController::class, 'create'])->name('machine-relation.create');
    Route::post('machine-relation',          [MachineRelationController::class, 'store'])->name('machine-relation.store');
    Route::get('machine-relation/{id}/edit', [MachineRelationController::class, 'edit'])->name('machine-relation.edit');
    Route::put('machine-relation/{id}',      [MachineRelationController::class, 'update'])->name('machine-relation.update');
    
    // ==================== PMS0031 [ กำหนดค่าเฝ้าระวัง ] ====================
    Route::get('setup-min-max-by-item', [SetupMinMaxByItemController::class, 'index'])->name('setup-min-max-by-item.index');
    Route::get('setup-min-max-by-item/updateOrCreate', [SetupMinMaxByItemController::class, 'updateOrCreate'])->name('setup-min-max-by-item.updateOrCreate');
    
    //PMS0032 : บันทึกคลังเบิกวัตถุดิบ
    Route::get('setup-transfer', [SetupTransferController::class, 'index'])->name('setup-transfer.index');
    Route::get('setup-transfer/edit/{id}', [SetupTransferController::class, 'edit'])->name('setup-transfer.edit');
    Route::post('setup-transfer/update', [SetupTransferController::class, 'update'])->name('setup-transfer.update');
    Route::get('setup-transfer/create', [SetupTransferController::class, 'create'])->name('setup-transfer.create');
    Route::post('setup-transfer/store', [SetupTransferController::class, 'store'])->name('setup-transfer.store');
    //PMS0036: บันทึกแปลงหน่วยสิ่งพิมพ์
    Route::get('print-conversion', [PrintConversionController::class, 'index'])->name('print-conversion.index');
    Route::post('print-conversion/createOrUpdate', [PrintConversionController::class, 'createOrUpdate'])->name('print-conversion.createOrUpdate');


    //PMS0039: กำหนด Product ประเภทสิ่งพิมพ์
    Route::get('print-product-type', [PrintProductTypeController::class, 'index'])->name('print-product-type.index');
    Route::post('print-product-type/update', [PrintProductTypeController::class, 'update'])->name('print-product-type.update');

    // PMS0030 กำหนดพื้นที่วางของ
    Route::get('max-storage', [MaxStorageController::class, 'index'])->name('max-storage.index');
    Route::get('max-storage/create', [MaxStorageController::class, 'create'])->name('max-storage.create');
    Route::post('max-storage', [MaxStorageController::class, 'store'])->name('max-storage.store');
    Route::get('max-storage/{id}/edit', [MaxStorageController::class, 'edit'])->name('max-storage.edit');
    Route::put('max-storage/{id}', [MaxStorageController::class, 'update'])->name('max-storage.update');
    Route::post('save-publication-layout-store', [SavePublicationLayoutController::class, 'store'])->name('save-publication-layout.store');

    //PMS0045
    Route::get('setup-before-notice', [SetupBeforeNoticeController::class, 'index'])->name('setup-before-notice.index');
    Route::post('setup-before-notice', [SetupBeforeNoticeController::class, 'store'])->name('setup-before-notice.store');

    Route::get('print-machine-group', [PrintMachineGroupController::class, 'index'])->name('print-machine-group.index');
    Route::get('print-machine-group/{id}/edit', [PrintMachineGroupController::class, 'edit']);
    Route::get('print-machine-group/update', [PrintMachineGroupController::class, 'update']);

    Route::get('machine-power-temp', [MachinePowerTempController::class, 'index'])->name('machine-power-temp.index');
    Route::get('machine-power-temp/{machineGroup}/{machineId}/{machineType}/edit', [MachinePowerTempController::class, 'edit']);
    Route::get('machine-power-temp/update', [MachinePowerTempController::class, 'update']);

    Route::get('/print-item-setup', [PrintItemSetupController::class, 'index'])->name('print-item-setup.index');   
    Route::get('/print-item-setup/create', [PrintItemSetupController::class, 'create'])->name('print-item-setup.create');   
    Route::get('/print-item-setup/store', [PrintItemSetupController::class, 'store'])->name('print-item-setup.store');
    Route::get('/print-item-setup/{id}/edit', [PrintItemSetupController::class, 'edit'])->name('print-item-setup.edit');
    Route::get('/print-item-setup/update', [PrintItemSetupController::class, 'update'])->name('print-item-setup.update');
    
});






    
