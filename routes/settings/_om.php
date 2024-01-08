<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OM\Settings\PaymentTermController;
use App\Http\Controllers\OM\Settings\PaymentTermExportController;
use App\Http\Controllers\OM\Settings\CountryController;
use App\Http\Controllers\OM\Settings\CustomerApprovalController;

use App\Http\Controllers\OM\Ajax\GeographyController;
use App\Http\Controllers\OM\Settings\SequenceEcomController;
use App\Http\Controllers\OM\Settings\QuotaCreditGroupController;
use App\Http\Controllers\OM\Settings\GrantSpacialCaseController;
use App\Http\Controllers\OM\Settings\AuthoRityListController;
use App\Http\Controllers\OM\Settings\OverQuotaApprovalController;
use App\Http\Controllers\OM\Settings\ItemWeightController;
use App\Http\Controllers\OM\Settings\DirectDebitDomesticController;
use App\Http\Controllers\OM\Settings\DirectDebitExportController;
use App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController;
use App\Http\Controllers\OM\Settings\ApproverOrderController;
use App\Http\Controllers\OM\Settings\AccountMappingController;
use App\Http\Controllers\OM\Settings\ThailandTerritoryController;
use App\Http\Controllers\OM\Settings\TransportOwnersController;
use App\Http\Controllers\OM\Settings\TransportationRoutesController;
use App\Http\Controllers\OM\Settings\OrderPeriodController;
use App\Http\Controllers\OM\Settings\ApproverOrderExportController;

use App\Http\Controllers\OM\Settings\NodeProvincesController;


use App\Http\Controllers\OM\Ajax\AccountSegmentController;
use App\Http\Controllers\OM\Ajax\ShipToSiteController;
use App\Http\Controllers\OM\Ajax\VendorController;
use App\Http\Controllers\OM\Ajax\SearchOrderPeriodController;
use App\Http\Controllers\OM\Ajax\SequenceEcomItemController;
use App\Http\Controllers\OM\Ajax\DirectDebitBankController;
use App\Http\Controllers\OM\Ajax\PriceListCheckController;



Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {

    Route::get('/geographies', [GeographyController::class, 'index']);
    Route::get('coa-mapping', [AccountSegmentController::class, 'index'])->name('coa-mapping.index');
    Route::get('sub-accounts', [AccountSegmentController::class, 'testSubAccount']);

    Route::get('ship-to-site', [ShipToSiteController::class, 'index']);

    Route::get('vendor', [VendorController::class, 'index'])->name('vendor.index');

    Route::get('search-order', [SearchOrderPeriodController::class, 'index'])->name('search-order.index');
    Route::get('get-order',    [SearchOrderPeriodController::class, 'getOrder'])->name('get-order.index');

    Route::get('get-item-cate', [SequenceEcomItemController::class, 'getItemCate'])->name('get-item-cate.index');
    Route::get('get-item',      [SequenceEcomItemController::class, 'getItem'])->name('get-item.index');

    
    Route::get('get-bank-branchs',  [DirectDebitBankController::class, 'getBankBranchs'])->name('get-bank-branchs.index');

    Route::get('get-check-header',  [PriceListCheckController::class, 'checkHeader'])->name('get-check-header.index');
    
    Route::get('get-check-header-date-to',  [PriceListCheckController::class, 'checkHeaderDateTo'])->name('get-check-header-date-to.index');
    
    Route::get('get-item-search',      [SequenceEcomItemController::class, 'getItemSearch'])->name('get-item-search.index');
    
});

Route::group(['namespace' => 'Settings', 'prefix' => 'settings', 'as' => 'settings.'], function () {

    // กำหนดเงื่อนไขการชำระเงิน (ในประเทศ) 
    Route::get('term', [PaymentTermController::class, 'index'])->name('term.index');
    Route::get('term/create', [PaymentTermController::class, 'create'])->name('term.create');
    Route::post('term', [PaymentTermController::class, 'store'])->name('term.store');
    Route::get('term/{term}/edit', [PaymentTermController::class, 'edit'])->name('term.edit');
    Route::put('term/{term}', [PaymentTermController::class, 'update'])->name('term.update');
    // กำหนดเงื่อนไขการชำระเงิน (ต่างประเทศ) 
    Route::get('term-export', [PaymentTermExportController::class, 'index'])->name('term-export.index');
    Route::get('term-export/create', [PaymentTermExportController::class, 'create'])->name('term-export.create');
    Route::post('term-export', [PaymentTermExportController::class, 'store'])->name('term-export.store');
    Route::get('term-export/{term}/edit', [PaymentTermExportController::class, 'edit'])->name('term-export.edit');
    Route::put('term-export/{term}', [PaymentTermExportController::class, 'update'])->name('term-export.update');

    // กำหนดประเทศ <OMS0011>
    Route::get('country', [CountryController::class, 'index'])->name('country.index');
    Route::get('country/create', [CountryController::class, 'create'])->name('country.create');
    Route::post('country', [CountryController::class, 'store'])->name('country.store');
    Route::get('country/{id}/edit', [CountryController::class, 'edit'])->name('country.edit');
    Route::put('country/{id}', [CountryController::class, 'update'])->name('country.update');

    // กำหนดสายการอนุมัติสำหรับอนุมัติสร้างลูกค้าใหม่ (ต่างประเทศ) <OMS0016>
    Route::get('customer', [CustomerApprovalController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerApprovalController::class, 'create'])->name('customer.create');
    Route::post('customer', [CustomerApprovalController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerApprovalController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerApprovalController::class, 'update'])->name('customer.update');
    Route::get('customer/primary-approval', [CustomerApprovalController::class, 'primaryApproval'])->name('customer.primary-approval');
 
    // กำหนดลำดับผลิตภัณฑ์ <OMS0026>
    Route::get('sequence-ecom', [SequenceEcomController::class, 'index'])->name('sequence-ecom.index');
    Route::get('sequence-ecom/create', [SequenceEcomController::class, 'create'])->name('sequence-ecom.create');
    Route::post('sequence-ecom', [SequenceEcomController::class, 'store'])->name('sequence-ecom.store');
    Route::get('sequence-ecom/{ecom}/edit', [SequenceEcomController::class, 'edit'])->name('sequence-ecom.edit');
    Route::put('sequence-ecom/{ecom}', [SequenceEcomController::class, 'update'])->name('sequence-ecom.update');
    // Route::delete('sequence-ecom/{ecom}', [SequenceEcomController::class, 'destroy'])->name('sequence-ecom.delete');


    // กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์ <OMS0023>
    Route::get('quota-credit-group', [QuotaCreditGroupController::class, 'index'])->name('quota-credit-group.index');
    Route::get('quota-credit-group/create', [QuotaCreditGroupController::class, 'create'])->name('quota-credit-group.create');
    Route::post('quota-credit-group', [QuotaCreditGroupController::class, 'store'])->name('quota-credit-group.store');
    Route::get('quota-credit-group/{id}/edit', [QuotaCreditGroupController::class, 'edit'])->name('quota-credit-group.edit');
    Route::put('quota-credit-group/{id}', [QuotaCreditGroupController::class, 'update'])->name('quota-credit-group.update');

    // กำหนดสิทธิ์สั่งซื้อพิเศษ <OMS0021>
    Route::get('grant-spacial-case', [GrantSpacialCaseController::class, 'index'])->name('grant-spacial-case.index');
    Route::get('grant-spacial-case/create', [GrantSpacialCaseController::class, 'create'])->name('grant-spacial-case.create');
    Route::post('grant-spacial-case', [GrantSpacialCaseController::class, 'store'])->name('grant-spacial-case.store');
    Route::get('grant-spacial-case/{id}/edit', [GrantSpacialCaseController::class, 'edit'])->name('grant-spacial-case.edit');
    Route::put('grant-spacial-case/{id}', [GrantSpacialCaseController::class, 'update'])->name('grant-spacial-case.update');
    Route::get('grant-spacial-case/{id}/delete', [GrantSpacialCaseController::class, 'destroy'])->name('grant-spacial-case.delete');

    // กำหนดผู้มีอำนาจ <OMS0024>
    Route::get('authority-list', [AuthoRityListController::class, 'index'])->name('authority-list.index');
    Route::get('authority-list/create', [AuthoRityListController::class, 'create'])->name('authority-list.create');
    Route::post('authority-list', [AuthoRityListController::class, 'store'])->name('authority-list.store');
    Route::get('authority-list/{id}/edit', [AuthoRityListController::class, 'edit'])->name('authority-list.edit');
    Route::put('authority-list/{id}', [AuthoRityListController::class, 'update'])->name('authority-list.update');

    // กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า <OMS0025>
    Route::get('over-quota-approval', [OverQuotaApprovalController::class, 'index'])->name('over-quota-approval.index');
    Route::get('over-quota-approval/create', [OverQuotaApprovalController::class, 'create'])->name('over-quota-approval.create');
    Route::post('over-quota-approval', [OverQuotaApprovalController::class, 'store'])->name('over-quota-approval.store');
    Route::get('over-quota-approval/{id}/edit', [OverQuotaApprovalController::class, 'edit'])->name('over-quota-approval.edit');
    Route::put('over-quota-approval/{id}', [OverQuotaApprovalController::class, 'update'])->name('over-quota-approval.update');
    Route::delete('over-quota-approval/{id}', [OverQuotaApprovalController::class, 'destroy'])->name('over-quota-approval.delete');

    // กำหนด Weight/Unit <OMS0031>
    Route::get('item-weight', [ItemWeightController::class, 'index'])->name('item-weight.index');
    Route::get('item-weight/create', [ItemWeightController::class, 'create'])->name('item-weight.create');
    Route::post('item-weight', [ItemWeightController::class, 'store'])->name('item-weight.store');
    Route::get('item-weight/{id}/edit', [ItemWeightController::class, 'edit'])->name('item-weight.edit');
    Route::put('item-weight/{id}', [ItemWeightController::class, 'update'])->name('item-weight.update');

    // Upload excel ข้อมูลอำเภอ/เขต, จังหวัด, ภาค, รหัสไปรษณีย์ ของประเทศไทย <OMS0018>
    Route::get('thailand-territory', [ThailandTerritoryController::class, 'index'])->name('thailand-territory.index');
    Route::post('thailand-territory/preview-import', [ThailandTerritoryController::class, 'previewImport'])->name('thailand-territory.preview-import');
    Route::post('thailand-territory/import', [ThailandTerritoryController::class, 'import'])->name('thailand-territory.import');
    Route::get('thailand-territory/download-excel-template', [ThailandTerritoryController::class, 'export'])->name('thailand-territory.download-excel-template');

    // Direct Debit Domestic <OMS0019>
    Route::get('direct-debit-domestic', [DirectDebitDomesticController::class, 'index'])->name('direct-debit-domestic.index');
    Route::get('direct-debit-domestic/create', [DirectDebitDomesticController::class, 'create'])->name('direct-debit-domestic.create');
    Route::post('direct-debit-domestic', [DirectDebitDomesticController::class, 'store'])->name('direct-debit-domestic.store');
    Route::get('direct-debit-domestic/{id}/edit', [DirectDebitDomesticController::class, 'edit'])->name('direct-debit-domestic.edit');
    Route::put('direct-debit-domestic/{id}', [DirectDebitDomesticController::class, 'update'])->name('direct-debit-domestic.update');

    // Direct Debit Export <OMS0020>
    Route::get('direct-debit-export', [DirectDebitExportController::class, 'index'])->name('direct-debit-export.index');
    Route::get('direct-debit-export/create', [DirectDebitExportController::class, 'create'])->name('direct-debit-export.create');
    Route::post('direct-debit-export', [DirectDebitExportController::class, 'store'])->name('direct-debit-export.store');
    Route::get('direct-debit-export/{id}/edit', [DirectDebitExportController::class, 'edit'])->name('direct-debit-export.edit');
    Route::put('direct-debit-export/{id}', [DirectDebitExportController::class, 'update'])->name('direct-debit-export.update');
    
    // ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ <OMS0029>
    Route::get('not-auto-release', [NotAutoReleaseReceiptController::class, 'index'])->name('not-auto-release.index');
    Route::get('not-auto-release/create', [NotAutoReleaseReceiptController::class, 'create'])->name('not-auto-release.create');
    Route::post('not-auto-release', [NotAutoReleaseReceiptController::class, 'store'])->name('not-auto-release.store');
    Route::get('not-auto-release/{id}/edit', [NotAutoReleaseReceiptController::class, 'edit'])->name('not-auto-release.edit');
    Route::put('not-auto-release/{id}', [NotAutoReleaseReceiptController::class, 'update'])->name('not-auto-release.update');

    
    // กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ <OMS0030>
    Route::get('approver-order', [ApproverOrderController::class, 'index'])->name('approver-order.index');
    Route::get('approver-order/create', [ApproverOrderController::class, 'create'])->name('approver-order.create');
    Route::post('approver-order', [ApproverOrderController::class, 'store'])->name('approver-order.store');
    Route::get('approver-order/{id}/edit', [ApproverOrderController::class, 'edit'])->name('approver-order.edit');
    Route::put('approver-order/{id}', [ApproverOrderController::class, 'update'])->name('approver-order.update');

    // กำหนด Mapping Account Code GL <OMS0017>
    // Route::resource('account-mapping', AccountMappingController::class);

    Route::get('account-mapping', [AccountMappingController::class, 'index'])->name('account-mapping.index');
    Route::get('account-mapping/create', [AccountMappingController::class, 'create'])->name('account-mapping.create');
    Route::post('account-mapping', [AccountMappingController::class, 'store'])->name('account-mapping.store');
    Route::get('account-mapping/{id}/edit', [AccountMappingController::class, 'edit'])->name('account-mapping.edit');
    Route::put('account-mapping/{id}', [AccountMappingController::class, 'update'])->name('account-mapping.update');

    


     //  <OMS00287
    Route::get('transport-owner', [TransportOwnersController::class, 'index'])->name('transport-owner.index');
    Route::get('transport-owner/create', [TransportOwnersController::class, 'create'])->name('transport-owner.create');
    Route::post('transport-owner', [TransportOwnersController::class, 'store'])->name('transport-owner.store');
    Route::get('transport-owner/{id}/edit', [TransportOwnersController::class, 'edit'])->name('transport-owner.edit');
    Route::put('transport-owner/{id}', [TransportOwnersController::class, 'update'])->name('transport-owner.update');
    Route::delete('transport-owner/{id}', [TransportOwnersController::class, 'destroy'])->name('transport-owner.delete');

    //OMS00287
    // Route::resource('transportation-route', TransportationRoutesController::class);

    // Route::get('\transportation-route', [TransportationRoutesController::class, 'index'])->name('transportation-route.index');
    Route::get('transportation-route', [TransportationRoutesController::class, 'index'])->name('transportation-route.index');
    Route::get('transportation-route/create', [TransportationRoutesController::class, 'create'])->name('transportation-route.create');
    Route::post('transportation-route', [TransportationRoutesController::class, 'store'])->name('transportation-route.store');
    Route::get('transportation-route/{id}/edit', [TransportationRoutesController::class, 'edit'])->name('transportation-route.edit');
    Route::put('transportation-route/{id}', [TransportationRoutesController::class, 'update'])->name('transportation-route.update');
    Route::delete('transportation-route/{id}', [TransportationRoutesController::class, 'destroy'])->name('transportation-route.delete');

    //  กำหนดงวดการสั่งซื้อ
    Route::get('order-period',           [OrderPeriodController::class, 'index'])->name('order-period.index');
    Route::get('order-period/create',    [OrderPeriodController::class, 'create'])->name('order-period.create');
    Route::post('order-period',          [OrderPeriodController::class, 'store'])->name('order-period.store');
    Route::get('order-period/{id}/edit', [OrderPeriodController::class, 'edit'])->name('order-period.edit');
    Route::put('order-period/{id}',      [OrderPeriodController::class, 'update'])->name('order-period.update');

    // กำหนดผู้อนุมัติใบ Sale Confirmation <OMS0033>
    Route::get('approver-order-export', [ApproverOrderExportController::class, 'index'])->name('approver-order-export.index');
    Route::get('approver-order-export/create', [ApproverOrderExportController::class, 'create'])->name('approver-order-export.create');
    Route::post('approver-order-export', [ApproverOrderExportController::class, 'store'])->name('approver-order-export.store');
    Route::get('approver-order-export/{id}/edit', [ApproverOrderExportController::class, 'edit'])->name('approver-order-export.edit');
    Route::put('approver-order-export/{id}', [ApproverOrderExportController::class, 'update'])->name('approver-order-export.update');

    //node 
    Route::get('node-province', [NodeProvincesController::class, 'index'])->name('node-province.index');
    Route::post('node-province/store', [NodeProvincesController::class, 'store'])->name('node-province.store');
    Route::post('node-province/update/{id}', [NodeProvincesController::class, 'update'])->name('node-province.update');
    Route::post('node-province/update-form', [NodeProvincesController::class, 'updateForm'])->name('node-province.update-form');
    Route::post('node-province/delete/{id}', [NodeProvincesController::class, 'delete'])->name('node-province.delete');
    Route::get('node-province/search', [NodeProvincesController::class, 'search'])->name('node-province.search');


});


