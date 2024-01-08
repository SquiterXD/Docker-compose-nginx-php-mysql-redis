<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OM\AdditionQuotaController;
use App\Http\Controllers\OM\Ajex\ApprovePrepareOrderAjaxController;
use App\Http\Controllers\OM\Ajex\BankAccountAjaxController;
use App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticAjaxController;
use App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController;
use App\Http\Controllers\OM\ApprovePrepareController;
use App\Http\Controllers\OM\ApproveSaleOrder\ApproveSaleOrderDebtController;
use App\Http\Controllers\OM\Customers\Domestics\DomesticController;
use App\Http\Controllers\OM\ReprintInvoice\ReprintInvoiceController;
use App\Http\Controllers\OM\ReprintInvoice\PrintInvoiceController;
use App\Http\Controllers\OM\PrepareSaleOrder\PrepareSaleOrderController;
use App\Http\Controllers\OM\PrintReceipt\PrintReceiptController;
use App\Http\Controllers\OM\Invoice\CancelInvoiceController;
use App\Http\Controllers\OM\ApproveSaleOrder\ApproveSaleOrderController;
use App\Http\Controllers\OM\InvoiceController;
use App\Http\Controllers\OM\CreditNote\CreditNoteRanchTransferController;
use App\Http\Controllers\OM\CreditNote\CreditNoteOtherController;
use App\Http\Controllers\OM\DebitNote\DebitNoteController;
use App\Http\Controllers\OM\DebitNote\DebitNoteExportController;
use App\Http\Controllers\OM\CreditNote\CreditNoteExportOtherController;

use App\Http\Controllers\OM\Ajex\OverdueDebtAjaxController;
use App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController;
use App\Http\Controllers\OM\Ajex\Invoice\CancelInvoiceAjaxController;
use App\Http\Controllers\OM\Ajex\PostponeDeliveryAjaxController;
use App\Http\Controllers\OM\Ajex\PrintReceipt\PrintReceiptAjaxController;
use App\Http\Controllers\OM\Ajex\PrintReceipt\ReprintReceiptAjaxController;
use App\Http\Controllers\OM\Ajex\PromotionAjaxController;
use App\Http\Controllers\OM\Ajex\ReleaseCreditAjaxController;
use App\Http\Controllers\OM\Ajex\ReprintInvoice\ReprintInvoiceAjaxController;
use App\Http\Controllers\OM\Ajex\PrepareSaleOrder\PrepareSaleOrderAjaxController;
use App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Domestic\MonthlyDistributeAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Domestic\TransferBiWeeklyAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Domestic\TransferMonthlyAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Domestic\YearDistributeAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Export\MonthlyDistributeExportAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Export\TranferBiWeeklyExportAjaxController;
use App\Http\Controllers\OM\Ajex\Saleorder\Export\YearDistributeExportAjaxController;

use App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController;
use App\Http\Controllers\OM\Ajex\TranspotReportController as AjexTranspotReportController;
use App\Http\Controllers\OM\Ajex\ApproveSaleOrder\ApproveSaleOrderDebtAjaxController;
use App\Http\Controllers\OM\Ajex\ApproveSaleOrder\ApproveSaleOrderAjaxController;

use App\Http\Controllers\OM\ApproveSaleConfirmationController;
use App\Http\Controllers\OM\BiweeklyPeriodsController;
use App\Http\Controllers\OM\ConsignmentController;
use App\Http\Controllers\OM\CustomerApprovesController;
use App\Http\Controllers\OM\Customers\Export\ExportController;
use App\Http\Controllers\OM\DeliveryRateController;
use App\Http\Controllers\OM\DraftPayOutController;
use App\Http\Controllers\OM\Export\PaymentMethodController as ExportPaymentMethodController;
use App\Http\Controllers\OM\Export\PaymentMethodMatchingController as ExportPaymentMethodMatchingController;
use App\Http\Controllers\OM\FormOrderHeaderController;
use App\Http\Controllers\OM\OrderDirectDebitController;
use App\Http\Controllers\OM\PaymentMethodController;
use App\Http\Controllers\OM\PaymentMethodMatchingController;
use App\Http\Controllers\OM\PostponeDeliveryController;

use App\Http\Controllers\OM\Ajex\BiweeklyPeriodsdAjaxController;
use App\Http\Controllers\OM\Ajex\ConsignmentClubAjaxController;
use App\Http\Controllers\OM\Ajex\ExchangeExportAjaxController;
use App\Http\Controllers\OM\Ajex\PrepareOrderAjaxController;
use App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController;
use App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController;
use App\Http\Controllers\OM\OverdueDebtController;
use App\Http\Controllers\OM\ProformaInvoiceController;
use App\Http\Controllers\OM\PromotionController;
use App\Http\Controllers\OM\ReleaseCreditController;
use App\Http\Controllers\OM\SaleConfirmationController;
use App\Http\Controllers\OM\Saleorder\Domestic\MonthlyDistributeController;
use App\Http\Controllers\OM\Saleorder\Domestic\TransferBiWeeklyController;
use App\Http\Controllers\OM\Saleorder\Domestic\TransferMonthlyController;
use App\Http\Controllers\OM\Saleorder\Domestic\YearDistributeController;
use App\Http\Controllers\OM\Saleorder\Export\MonthlyDistributeExportController;
use App\Http\Controllers\OM\Saleorder\Export\TranferBiWeeklyExportController;
use App\Http\Controllers\OM\Saleorder\Export\YearDistributeExportController;
use App\Http\Controllers\OM\SequenceFortnightlyController;
use App\Http\Controllers\OM\TranspotReportController;
use App\Http\Controllers\OM\ConsignmentClubController;
use App\Http\Controllers\OM\ClosedFlagSaleController;
use App\Http\Controllers\OM\Ajex\ReprintInvoice\PrintInvoiceAjaxController;
use App\Http\Controllers\OM\ClosedFlagPaymentController;
use App\Http\Controllers\OM\PrintReceipt\ReprintReceiptController;
use App\Http\Controllers\OM\TransferProvinceController;
use App\Http\Controllers\OM\ApprovePrepareOrderController;
use App\Http\Controllers\OM\TaxAdjustmentController;
use App\Http\Controllers\OM\TransferCommissionController;
use App\Http\Controllers\OM\PrepareOrderController;
use App\Http\Controllers\OM\AttachmentController;
use App\Http\Controllers\OM\ExchangeExportController;
use App\Http\Controllers\OM\RmaExportController;
use App\Http\Controllers\OM\TaxInvoiceExportController;
use App\Http\Controllers\OM\TransferFileBankController;
use App\Http\Controllers\OM\Settings\PriceListController;
use App\Http\Controllers\OM\Settings\PriceListExportController;
use App\Http\Controllers\OM\Ajex\CreditNote\CreditNoteRanchTransferAjaxController;
use App\Http\Controllers\OM\Ajex\CreditNote\CreditNoteOtherAjaxController;
use App\Http\Controllers\OM\Ajex\DebitNote\DebitNoteAjaxController;
use App\Http\Controllers\OM\Ajex\DebitNote\DebitNoteExportAjaxController;
use App\Http\Controllers\OM\Ajex\CreditNote\CreditNoteExportOtherAjaxController;
use App\Http\Controllers\OM\AutoController;
use App\Http\Controllers\OM\PaoTaxMtController;
use App\Http\Controllers\OM\TransferTxtToBankController;
use App\Http\Controllers\OM\CloseDailySaleController;
use App\Http\Controllers\OM\CloseDailyPayoffController;
use App\Http\Controllers\OM\ConsignmentBkkController;
use App\Http\Controllers\OM\CutStockInventoryController;
use App\Http\Controllers\OM\ProductReturnController;
use App\Http\Controllers\OM\PaoPercentController;
use App\Http\Controllers\OM\ApprovalClaimController;
use App\Http\Controllers\OM\Ajax\ApprovalClaimController As AjaxApprovalClaimController;


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


require base_path('routes/settings/_om.php');
require base_path('routes/_om_mcr.php');
require base_path('routes/om_prepare_sale_order.php');

Route::group(['namespace' => 'Settings', 'prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::get('price-list', [PriceListController::class, 'index'])->name('price-list.index');
    Route::get('price-list/create', [PriceListController::class, 'create'])->name('price-list.create');
    Route::post('price-list', [PriceListController::class, 'store'])->name('price-list.store');
    Route::get('price-list/{id}/show', [PriceListController::class, 'show'])->name('price-list.show');
    Route::get('price-list/{id}/edit', [PriceListController::class, 'edit'])->name('price-list.edit');
    Route::put('price-list/{id}', [PriceListController::class, 'update'])->name('price-list.update');

    Route::get('price-list-export', [PriceListExportController::class, 'index'])->name('price-list-export.index');
    Route::get('price-list-export/create', [PriceListExportController::class, 'create'])->name('price-list-export.create');
    Route::post('price-list-export', [PriceListExportController::class, 'store'])->name('price-list-export.store');
    Route::get('price-list-export/{id}/show', [PriceListExportController::class, 'show'])->name('price-list-export.show');
    Route::get('price-list-export/{id}/edit', [PriceListExportController::class, 'edit'])->name('price-list-export.edit');
    Route::put('price-list-export/{id}', [PriceListExportController::class, 'update'])->name('price-list-export.update');

});

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::prefix('exports')->name('exports.')->group(function () {
            Route::post('list', [ExportAjaxController::class, 'List'])->name('exports.list');
            Route::get('type', [ExportAjaxController::class, 'Type'])->name('exports.type');
            Route::get('country', [ExportAjaxController::class, 'Country'])->name('exports.country');
            Route::get('province', [ExportAjaxController::class, 'Province']);
            Route::get('district', [ExportAjaxController::class, 'District']);
            Route::get('tambon', [ExportAjaxController::class, 'Tambon']);

            Route::post('check_contact/{id}', [ExportAjaxController::class, 'checkContactActive']);
            Route::get('customercontact_list/{id}', [ExportAjaxController::class, 'CustomerContactList'])->name('foreign.customercontact_list');
            Route::get('customershipping_list/{id}', [ExportAjaxController::class, 'CustomerShippingList'])->name('foreign.customershipping_list');
            Route::post('confirmcustomer/{id}', [ExportAjaxController::class, 'confirmDataCustomer']);
            Route::post('updateCustomer/{id}', [ExportAjaxController::class, 'updateCustomerData']);
            Route::post('insertcustomercontact/{id}', [ExportAjaxController::class, 'insertCustomerContact'])->name('foreign.insertcustomercontact');
            Route::post('updatecustomercontact/{id}', [ExportAjaxController::class, 'updateCustomerContact'])->name('foreign.updatecustomercontact');
            Route::post('delcustomercontact/{id}', [ExportAjaxController::class, 'delCustomerContact']);
            Route::post('insertcustomershipping/{id}', [ExportAjaxController::class, 'insertCustomerShipping'])->name('foreign.insertcustomershipping');
            Route::post('updatecustomershipping/{id}', [ExportAjaxController::class, 'updateCustomerShipping'])->name('foreign.updatecustomershipping');
            Route::post('delcustomershipping/{id}', [ExportAjaxController::class, 'delCustomerShipping']);
        });

        Route::prefix('domestics')->name('domestics.')->group(function () {
            Route::post('list',             [DomesticAjaxController::class, 'List']);
            Route::post('insertagent',      [DomesticAjaxController::class, 'insertAgent']);

            Route::post('insert-customers', [DomesticsAjaxController::class, 'insertCustomers'])->name('domestics.insert.customers');

            Route::post('insert-customers-shipsites', [DomesticsAjaxController::class, 'insertCustomersShipSites'])->name('domestics.insert.customers-shipsites');
            Route::post('insert-customers-previous', [DomesticsAjaxController::class, 'insertCustomersPrevious'])->name('domestics.insert.customers-previous');
            Route::post('insert-customers-owner', [DomesticsAjaxController::class, 'insertCustomersOwner'])->name('domestics.insert.customers-owner');

            Route::post('insert-customers-contracts', [DomesticsAjaxController::class, 'insertCustomersContracts'])->name('domestics.insert.customers-contracts');
            Route::post('insert-customers-contractbooks', [DomesticsAjaxController::class, 'insertCustomersContractBooks'])->name('domestics.insert.customers-contractbooks');
            Route::post('insert-customers-contractgroup', [DomesticsAjaxController::class, 'insertCustomersContractGroups'])->name('domestics.insert.customers-contractgroup');

            Route::post('insert-customers-quota', [DomesticsAjaxController::class, 'insertCustomersQuota'])->name('domestics.insert.customers-quota');

            Route::post('update-customers/{id}', [DomesticsAjaxController::class, 'updateCustomers'])->name('domestics.update.customers');
            Route::post('update-customers-previous/{id}', [DomesticsAjaxController::class, 'updateCustomersPrevious'])->name('domestics.update.customers-previous');
            Route::post('update-customers-owner/{id}', [DomesticsAjaxController::class, 'updateCustomersOwner'])->name('domestics.update.customers-owner');
            Route::post('update-customers-shipsites/{id}', [DomesticsAjaxController::class, 'updateCustomersShipSites'])->name('domestics.update.customers-shipsites');
            Route::post('update-customers-quota/{id}', [DomesticsAjaxController::class, 'updateCustomersQuota'])->name('domestics.update.customers-quota');

            Route::get('previous/{id}', [DomesticsAjaxController::class, 'showPrevious'])->name('previous');
            Route::get('owner/{id}', [DomesticsAjaxController::class, 'showOwner'])->name('owner');
            Route::get('quota-headers/{id}', [DomesticsAjaxController::class, 'showQuotaHeaders'])->name('quota-headers');
            Route::get('ship-sites/{id}', [DomesticsAjaxController::class, 'showShipSites'])->name('ship-sites');
            Route::get('quota-lines-item/{id}', [DomesticsAjaxController::class, 'showLinesItems'])->name('quota.lines.items');
            Route::get('province-list/{id}', [DomesticsAjaxController::class, 'provinceList'])->name('province.list');
            Route::get('city-list/{id}/{shipid}', [DomesticsAjaxController::class, 'cityList'])->name('city.list');
            Route::get('district-list/{id}/{shipid}', [DomesticsAjaxController::class, 'districtList'])->name('district.list');
            Route::get('postcode/{id}/{shipid}', [DomesticsAjaxController::class, 'postCode'])->name('postcode');
            Route::get('get-ship-site-name/{id}/{shipid}', [DomesticsAjaxController::class, 'getShiptoSiteName'])->name('get.ship.site.name');
            Route::get('get-customer-name/{id}', [DomesticsAjaxController::class, 'getCustomerName'])->name('get.customer.name');

            Route::post('list',             [DomesticsAjaxController::class, 'List']);
            Route::post('insertagent',      [DomesticsAjaxController::class, 'insertAgent']);
            Route::post('remove',           [DomesticsAjaxController::class, 'deleteAgent']);

            Route::get('delete-customers-shipsites/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersShipSites'])->name('domestics.delete.customers-shipsites');
            Route::get('delete-customers-previous/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersPrevious'])->name('domestics.delete.customers-previous');
            Route::get('delete-customers-owner/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersOwner'])->name('domestics.delete.customers-owner');
            Route::get('delete-customers-contracts/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersContracts'])->name('domestics.delete.customers-contracts');
            Route::get('delete-customers-contractbooks/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersContractBooks'])->name('domestics.delete.customers-contractbooks');
            Route::get('delete-customers-contractgroups/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersContractGroups'])->name('domestics.delete.customers-contractgroups');
            Route::get('delete-customers-quota/{id}/{customer_id}', [DomesticsAjaxController::class, 'deleteCustomersQuota'])->name('domestics.delete.customers-quota');
            Route::get('delete-customers-quota-line/{id}', [DomesticsAjaxController::class, 'deleteCustomersQuotaLines'])->name('domestics.delete.customers-quota-line');
        });
    });

    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('all-products', [PromotionAjaxController::class, 'allProduct']);
        Route::get('all-promotion', [PromotionAjaxController::class, 'allPromotion']);
        Route::get('all-customers', [PromotionAjaxController::class, 'allCustomer']);
        Route::get('search-customers/{customer_number}', [PromotionAjaxController::class, 'searchCustomer']);
        Route::get('all-uom', [PromotionAjaxController::class, 'allUom']);
        Route::get('set-customer-modal', [PromotionAjaxController::class, 'setModalCustomer']);
        Route::get('set-customer-modal/promo/{promotion_id}', [PromotionAjaxController::class, 'setModalCustomerPromo']);
        Route::get('runnumber', [PromotionAjaxController::class, 'runNumber']);
        Route::post('search', [PromotionAjaxController::class, 'search']);
        Route::post('search-promotion', [PromotionAjaxController::class, 'searchPromotion']);
        Route::get('search-group-product/{itemId}', [PromotionAjaxController::class, 'searchGroupProduct']);
        Route::post('store', [PromotionAjaxController::class, 'store'])->name('store');
        Route::post('update', [PromotionAjaxController::class, 'update'])->name('update');
        Route::post('remove', [PromotionAjaxController::class, 'remove'])->name('remove');
        Route::post('copy', [PromotionAjaxController::class, 'copyPromotion'])->name('copy');
    });

    Route::prefix('release-credit')->name('release_credit.')->group(function () {
        Route::get('customers/{id}', [ReleaseCreditAjaxController::class, 'customers']);
    });

    Route::prefix('bank')->name('bank.')->group(function () {
        Route::get('byid/{id}', [BankAccountAjaxController::class, 'byBankId']);
        Route::get('by-short-name/{id}', [BankAccountAjaxController::class, 'byShortName']);
    });

    Route::prefix('postpone-delivery')->name('postpone-delivery.')->group(function () {
        Route::post('create', [PostponeDeliveryAjaxController::class, 'store']);
        Route::post('search', [PostponeDeliveryAjaxController::class, 'search']);
        Route::post('remove', [PostponeDeliveryAjaxController::class, 'remove']);
        Route::get('years', [PostponeDeliveryAjaxController::class, 'years']);
        Route::get('period-by-years/{year}', [PostponeDeliveryAjaxController::class, 'periodByBudgetYear'])->name('period_by_years');
        Route::get('date-by-no/{customer_number}/{year}', [PostponeDeliveryAjaxController::class, 'dateByNo']);
        Route::get('installments/{year}', [PostponeDeliveryAjaxController::class, 'installments']);
        Route::get('next-date/{number}', [PostponeDeliveryAjaxController::class, 'nextDate']);
        Route::get('get-customers/{date}', [PostponeDeliveryAjaxController::class, 'getCustomers']);
        Route::get('get-period-post-pone/{year}', [PostponeDeliveryAjaxController::class, 'getPeriodPostPone']);
        Route::get('get-date-by-period-post-pone', [PostponeDeliveryAjaxController::class, 'getDateByPeriodPostPone']);
        Route::get('get-period-post-pone-by-date', [PostponeDeliveryAjaxController::class, 'getPeriodPostPoneByDate']);
    });

    Route::prefix('transfer-bi-weekly')->name('transfer-bi-weekly.')->group(function () {
        Route::post('inportexcel',      [TransferBiWeeklyAjaxController::class, 'importExcel']);
        Route::post('versionbiweek',    [TransferBiWeeklyAjaxController::class, 'versionListBiweek']);
        Route::post('yearbiweek',       [TransferBiWeeklyAjaxController::class, 'yearListBiweek']);
        Route::post('searchbiweekly',   [TransferBiWeeklyAjaxController::class, 'seachBiWeekly']);
        Route::post('savevalue',        [TransferBiWeeklyAjaxController::class, 'saveValue']);
        Route::post('approved',         [TransferBiWeeklyAjaxController::class, 'approve_biweek']);
        Route::post('sendfactory',      [TransferBiWeeklyAjaxController::class, 'sendFactory']);
        Route::post('testcash',         [TransferBiWeeklyAjaxController::class, 'testcash']);
    });

    Route::prefix('transfer-bi-weekly-export')->name('transfer-bi-weekly.')->group(function () {
        Route::post('versionbiweek',    [TranferBiWeeklyExportAjaxController::class, 'versionListBiweek']);
        Route::post('yearbiweek',       [TranferBiWeeklyExportAjaxController::class, 'yearListBiweek']);
        Route::post('searchbiweekly',   [TranferBiWeeklyExportAjaxController::class, 'seachBiWeekly']);
        Route::post('approved',         [TranferBiWeeklyExportAjaxController::class, 'approve_biweek']);
        Route::post('sendfactory',      [TranferBiWeeklyExportAjaxController::class, 'sendFactory']);
    });


    Route::prefix('overdue-debt')->name('overdue-debt.')->group(function () {
        Route::post('search', [OverdueDebtAjaxController::class, 'searchOverdueDebt']);
        Route::get('get-customer-name/{id}', [OverdueDebtAjaxController::class, 'getCustomersName'])->name('get-customer-name');
    });

    Route::prefix('fortnightly')->name('fortnightly')->group(function () {
        Route::get('sequence-ecom', [SequenceFortnightlyAjaxController::class, 'sequenceEcoms']);
        Route::post('update-sequence-ecom', [SequenceFortnightlyAjaxController::class, 'updateSequenceEcoms'])->name('update.sequence.ecom');
        Route::post('delete-sequence-ecom', [SequenceFortnightlyAjaxController::class, 'deleteSequenceEcoms'])->name('delete.sequence.ecom');
        Route::post('filter-sequence-ecom', [SequenceFortnightlyAjaxController::class, 'filterSequenceEcoms'])->name('filter.sequence.ecom');
    });

    Route::prefix('prepare-saleorder')->group(function () {
        Route::post('get_uomlist',              [PrepareSaleOrderAjaxController::class, 'getUomList']);
        Route::post('get_uomlist_product',      [PrepareSaleOrderAjaxController::class, 'getUomListProduct']);
        Route::post('get_orderlist',            [PrepareSaleOrderAjaxController::class, 'getOrderList']);
        Route::post('genpo_number',             [PrepareSaleOrderAjaxController::class, 'genPoNumber']);
        Route::post('save_darft',               [PrepareSaleOrderAjaxController::class, 'SaveDraft']);
        Route::post('get_shipsite',             [PrepareSaleOrderAjaxController::class, 'getShipSite']);
        Route::post('get_delivary',             [PrepareSaleOrderAjaxController::class, 'getDelivary']);
        Route::post('get_productlist',          [PrepareSaleOrderAjaxController::class, 'getProductItem']);
        Route::post('search_saleorder',         [PrepareSaleOrderAjaxController::class, 'searchPrepareSaleOrder']);
        Route::post('getlotdata',               [PrepareSaleOrderAjaxController::class, 'getLotData']);
        Route::post('copy_order',               [PrepareSaleOrderAjaxController::class, 'copyDataSaleOrder']);
        Route::post('save_approve',             [PrepareSaleOrderAjaxController::class, 'sendApprove']);
        Route::post('save_cancel',              [PrepareSaleOrderAjaxController::class, 'orderCanceller']);
        Route::post('get-org-list',             [PrepareSaleOrderAjaxController::class, 'selectOrgData']);
        Route::post('get-org-onhand',           [PrepareSaleOrderAjaxController::class, 'getDataLotOnhand']);
        Route::post('test-call-wms',            [PrepareSaleOrderAjaxController::class, 'testcallWMS']);
    });

    Route::prefix('approve-saleorder')->group(function () {
        Route::post('search_saleorder', [ApproveSaleOrderAjaxController::class, 'searchSaleOrder']);
        Route::post('update_status', [ApproveSaleOrderAjaxController::class, 'updateStatusSaleOrder']);
    });

    Route::prefix('biweekly')->name('biweekly')->group(function () {
        Route::post('update-periods', [BiweeklyPeriodsdAjaxController::class, 'updateBiweeklyPeriods'])->name('update.periods');
        Route::get('get-holiday/{number}', [BiweeklyPeriodsdAjaxController::class, 'getHoliday'])->name('get.holiday');
        Route::get('search-periods/{number}', [BiweeklyPeriodsdAjaxController::class, 'searchBiweeklyPeriods'])->name('search.periods');
    });
    Route::prefix('transfer-monthly')->name('transfer-monthly.')->group(function () {
        Route::post('inportexcel', [TransferMonthlyAjaxController::class, 'importexcel']);
        Route::get('export-example', [TransferMonthlyAjaxController::class, 'export_example']);

    });

    Route::prefix('monthly-distribute')->group(function () {
        Route::post('inportexcel',      [MonthlyDistributeAjaxController::class, 'importexcel']);
        Route::post('versionmonthly',   [MonthlyDistributeAjaxController::class, 'versionListMonthly']);
        Route::post('searchmonthly',    [MonthlyDistributeAjaxController::class, 'seachMonthly']);
        Route::post('savevalue',        [MonthlyDistributeAjaxController::class, 'saveValue']);
        Route::post('approved',         [MonthlyDistributeAjaxController::class, 'approve_Monthly']);
        Route::post('sendfactory',      [MonthlyDistributeAjaxController::class, 'sendFactory']);
    });

    Route::prefix('monthly-distribute-export')->group(function () {
        Route::post('versionmonthly',   [MonthlyDistributeExportAjaxController::class, 'versionListMonthly']);
        Route::post('searchmonthly',    [MonthlyDistributeExportAjaxController::class, 'seachMonthly']);
        Route::post('approved',         [MonthlyDistributeExportAjaxController::class, 'approve_Monthly']);
        Route::post('sendfactory',      [MonthlyDistributeExportAjaxController::class, 'sendFactory']);
    });

    Route::prefix('print-invoice')->group(function () {
        Route::post('customer_list',    [PrintInvoiceAjaxController::class, 'customer_list']);
        Route::post('searchprint',      [PrintInvoiceAjaxController::class, 'search_order']);
        Route::post('save_print',       [PrintInvoiceAjaxController::class, 'print_data']);
        Route::post('creditNoteList',   [PrintInvoiceAjaxController::class, 'creditNoteList']);
    });

    Route::prefix('year-distribute')->group(function () {
        Route::post('inportexcel',  [YearDistributeAjaxController::class, 'importexcel']);
        Route::post('versionyear',  [YearDistributeAjaxController::class, 'versionListYear']);
        Route::post('searchyear',   [YearDistributeAjaxController::class, 'seachYear']);
        Route::post('savevalue',    [YearDistributeAjaxController::class, 'saveValue']);
        Route::post('approved',     [YearDistributeAjaxController::class, 'approve_Yearly']);
        Route::post('sendfactory',  [YearDistributeAjaxController::class, 'sendFactory']);
    });

    Route::prefix('year-distribute-export')->group(function () {
        Route::post('versionyear',  [YearDistributeExportAjaxController::class, 'versionListYear']);
        Route::post('searchyear',   [YearDistributeExportAjaxController::class, 'seachYear']);
        Route::post('approved',     [YearDistributeExportAjaxController::class, 'approve_Yearly']);
        Route::post('sendfactory',  [YearDistributeExportAjaxController::class, 'sendFactory']);
    });

    Route::prefix('consignment-club')->name('consignment-club')->group(function () {
        Route::post('search-create', [ConsignmentClubAjaxController::class, 'createConsignment'])->name('search.consignment');
        Route::get('get-order-lines/{number}', [ConsignmentClubAjaxController::class, 'getOrderLines'])->name('get.order.lines');
        Route::post('search-consignment-club', [ConsignmentClubAjaxController::class, 'searConsignment'])->name('search.consignment.club');
        Route::post('update-consignment-club', [ConsignmentClubAjaxController::class, 'updateConsignment'])->name('update.consignment.club');
        Route::get('get-delivery-period-tag/{releasenum}/{number}', [ConsignmentClubAjaxController::class, 'getDeliveryPeriodTag'])->name('get.delivery.period.tag');
    });

    Route::prefix('reprint-invoice')->group(function () {
        Route::post('searchinvoice', [ReprintInvoiceAjaxController::class, 'searchinvoice']);
        Route::post('save_reprint', [ReprintInvoiceAjaxController::class, 'savereprint']);
    });

    Route::prefix('sale-confirmation')->name('sale-confirmation')->group(function () {
        Route::post('update-order', [SaleConfirmationAjaxController::class, 'updateOrderHeaders'])->name('update.order');
        Route::post('search', [SaleConfirmationAjaxController::class, 'search'])->name('search');
        Route::post('create-sale-confirmation', [SaleConfirmationAjaxController::class, 'createSaleConfirmation'])->name('create.sale.confirmation');
        Route::get('copy-sale-number/{number}', [SaleConfirmationAjaxController::class, 'copySaleConfirmationNumber'])->name('copy.sale.number');
        Route::get('create-sale-number', [SaleConfirmationAjaxController::class, 'createSaleConfirmationNumber'])->name('create.sale.number');
        Route::post('update-sale-confirmation', [SaleConfirmationAjaxController::class, 'updateSaleConfirmation'])->name('update.sale.confirmation');
        Route::post('confirm-sale-confirmation', [SaleConfirmationAjaxController::class, 'confirmSaleConfirmation'])->name('confirm.sale.confirmation');
        Route::post('copy-to-proforma-invoice', [SaleConfirmationAjaxController::class, 'copyToProformaInvoice'])->name('copy.to.proforma.invoice');
        Route::get('check-cancel/{number}', [SaleConfirmationAjaxController::class, 'checkCancel'])->name('check-cancel');
        Route::post('cancel', [SaleConfirmationAjaxController::class, 'cancel'])->name('cancel');
        Route::get('customer-shipsite/{number}', [SaleConfirmationAjaxController::class, 'customerShipsite'])->name('customer-shipsite');
        Route::get('check-outstanding-debt/{number}', [SaleConfirmationAjaxController::class, 'checkOutstandingDebt'])->name('check-outstanding-debt');
    });

    Route::prefix('approve-prepare-order')->name('approve-prepare-order')->group(function () {
        Route::post('search', [ApprovePrepareOrderAjaxController::class, 'searchApprovePrepareOrder'])->name('search');
        Route::post('manage', [ApprovePrepareOrderAjaxController::class, 'managePrepareOrder'])->name('manage');
        Route::get('get-payment-state/{number}/{id}', [ApprovePrepareOrderAjaxController::class, 'getPaymentState'])->name('get-payment-state');
        Route::post('cancel', [ApprovePrepareOrderAjaxController::class, 'cancelPrepareOrder'])->name('cancel');
    });

    Route::prefix('order/approveprepara')->name('order.approveprepare.')->group(function () {
        Route::post('/search', [ApprovePrepareController::class, 'search'])->name('search');
        Route::get('/search/customer', [ApprovePrepareController::class, 'searchCustomer'])->name('search.customer');
        Route::post('/confirm', [ApprovePrepareController::class, 'confirmOrder'])->name('confirm');
        Route::post('/cancel', [ApprovePrepareController::class, 'cancelOrder'])->name('cancel');
    });

    Route::prefix('order/prepare')->name('order.prepare.')->group(function () {
        // Route::get('/search', [PrepareOrderController::class, 'search'])->name('search');
        // Route::get('/search/customer', [PrepareOrderController::class,'searchcustomer'])->name('search.customer');
        // Route::post('/fetch/customer', [PrepareOrderController::class,'fetchcustomer'])->name('fetch.customer');
        Route::get('/run-number', [PrepareOrderAjaxController::class, 'runPrepareNumber'])->name('run_number');
        Route::get('/data-customer', [PrepareOrderAjaxController::class, 'dataByCustomer'])->name('data_customer');
        Route::get('/data-item', [PrepareOrderAjaxController::class, 'dataByItem'])->name('data_item');
        Route::get('/product-by-type', [PrepareOrderAjaxController::class, 'productByOrderType'])->name('product_by_type');
        Route::post('/set-dayamount', [PrepareOrderAjaxController::class, 'setDayAmount'])->name('set_dayamount');
    });
    Route::prefix('order/approve')->name('order.approve.')->group(function () {
        Route::post('/search', '\App\Http\Controllers\OM\ApproveOrderController@searchItem')->name('search.item');
        Route::post('/approve', '\App\Http\Controllers\OM\ApproveOrderController@approve')->name('submit');
        Route::post('/cancel', '\App\Http\Controllers\OM\ApproveOrderController@cancel')->name('cancel');
    });

    Route::prefix('reprint-receipt')->group(function () {
        Route::post('searchreceipt',        [ReprintReceiptAjaxController::class, 'searchReprint']);
        Route::post('reprint_data',         [ReprintReceiptAjaxController::class, 'reprint_receipt']);
    });

    Route::prefix('print-receipt')->group(function () {
        Route::post('searchreceipt', [PrintReceiptAjaxController::class, 'searchRecreipt']);
        Route::post('print_data', [PrintReceiptAjaxController::class, 'print_receipt']);
    });

    Route::prefix('invoice_cancel')->group(function () {
        Route::post('list', [CancelInvoiceAjaxController::class, 'invoice_list']);
        Route::post('save', [CancelInvoiceAjaxController::class, 'invoice_save']);
    });

    Route::prefix('proforma-invoice')->name('proforma-invoice')->group(function () {
        Route::get('search-pi-number/{number}', [ProformaInvoiceAjaxController::class, 'searchProformaInvoiceNumber'])->name('search.sale.number');
        Route::post('search', [ProformaInvoiceAjaxController::class, 'search'])->name('search');
        Route::get('create-proforma-invoice/{number}', [ProformaInvoiceAjaxController::class, 'createProformaInvoice'])->name('create.proforma.invoice');
        Route::post('manage-proforma-invoice', [ProformaInvoiceAjaxController::class, 'manageProformaInvoice'])->name('manage.proforma.invoice');
        Route::get('create-proforma-lot/{number}', [ProformaInvoiceAjaxController::class, 'createProformaLot'])->name('create.proforma.lot');
        Route::get('get-proforma-lot/{number}', [ProformaInvoiceAjaxController::class, 'getProformaLot'])->name('get.proforma.lot');
        Route::get('check-cancel/{number}', [ProformaInvoiceAjaxController::class, 'checkCancel'])->name('check-cancel');
        Route::post('cancel', [ProformaInvoiceAjaxController::class, 'cancel'])->name('cancel');
        Route::post('update-lot', [ProformaInvoiceAjaxController::class, 'updateLot'])->name('update-lot');
        Route::post('delete-all-lot', [ProformaInvoiceAjaxController::class, 'deleteAllLot'])->name('delete.all.lot');
        Route::post('delete-lot-data', [ProformaInvoiceAjaxController::class, 'deleteSingleLot'])->name('delete.lot.data');
    });

    Route::prefix('tax-invoice-export')->name('tax-invoice-export')->group(function () {
        Route::post('create', [TaxInvoiceExportAjaxController::class, 'create'])->name('create');
        Route::post('search', [TaxInvoiceExportAjaxController::class, 'search'])->name('search');
        Route::post('manage', [TaxInvoiceExportAjaxController::class, 'manage'])->name('manage');
        Route::get('check-cancel/{id}/{number}', [TaxInvoiceExportAjaxController::class, 'checkCancel'])->name('check.cancel');
        Route::post('cancel', [TaxInvoiceExportAjaxController::class, 'cancel'])->name('cancel');
        Route::get('close-work/{number}', [TaxInvoiceExportAjaxController::class, 'closeWork'])->name('close.work');
    });

    Route::prefix('creditnote_ranchtran')->group(function () {
        Route::post('gencreatenumber', [CreditNoteRanchTransferAjaxController::class, 'genNumberCreditNote']);
        Route::post('getcreditnote',   [CreditNoteRanchTransferAjaxController::class, 'getCaditNoteList']);
        Route::post('customer_list', [CreditNoteRanchTransferAjaxController::class, 'get_customer']);
        Route::post('clubassocia_list', [CreditNoteRanchTransferAjaxController::class, 'get_club_association']);
        Route::post('channelreceiving_list', [CreditNoteRanchTransferAjaxController::class, 'get_channel_receiving']);
        Route::post('accountmapping_list', [CreditNoteRanchTransferAjaxController::class, 'get_account_mapping']);
        Route::post('consignment_list', [CreditNoteRanchTransferAjaxController::class, 'get_consignment']);
        Route::post('create_invoice', [CreditNoteRanchTransferAjaxController::class, 'save_invoice']);
        Route::post('edit_invoice', [CreditNoteRanchTransferAjaxController::class, 'edit_invoice']);
        Route::post('cancel_invoice', [CreditNoteRanchTransferAjaxController::class, 'cancel_invoice']);
        Route::post('search_invoice', [CreditNoteRanchTransferAjaxController::class, 'Search_invoice']);
    });

    Route::prefix('credit-note-other')->group(function () {
        Route::post('getcreditnote',            [CreditNoteOtherAjaxController::class, 'getCreditNoteList']);
        Route::post('gencreatenumber',          [CreditNoteOtherAjaxController::class, 'createCreditNote']);
        Route::post('customer_list',            [CreditNoteOtherAjaxController::class, 'getCustomer']);
        Route::post('channelreceiving_list',    [CreditNoteOtherAjaxController::class, 'getChannelReceiving']);
        Route::post('get_order',                [CreditNoteOtherAjaxController::class, 'getOrder']);
        Route::post('save_invoice',             [CreditNoteOtherAjaxController::class, 'saveInvoice']);
        Route::post('search_invoice',           [CreditNoteOtherAjaxController::class, 'searchInvoice']);
        Route::post('cancel_invoice',           [CreditNoteOtherAjaxController::class, 'cancelInvoice']);
    });

    Route::prefix('credit-note-other_export')->group(function () {
        Route::post('getcreditnote',            [CreditNoteExportOtherAjaxController::class, 'getCreditNoteList']);
        Route::post('gencreatenumber', [CreditNoteExportOtherAjaxController::class, 'createCreditNote']);
        Route::post('customer_list', [CreditNoteExportOtherAjaxController::class, 'getCustomer']);
        Route::post('channelreceiving_list', [CreditNoteExportOtherAjaxController::class, 'getChannelReceiving']);
        Route::post('get_order', [CreditNoteExportOtherAjaxController::class, 'getOrder']);
        Route::post('save_invoice', [CreditNoteExportOtherAjaxController::class, 'saveInvoice']);
        Route::post('search_invoice', [CreditNoteExportOtherAjaxController::class, 'searchInvoice']);
        Route::post('cancel_invoice', [CreditNoteExportOtherAjaxController::class, 'cancelInvoice']);

    });

    Route::prefix('debitnote_ranchtran')->group(function () {
        Route::post('getdebitnote',     [DebitNoteAjaxController::class, 'getDebitNoteList']);
        Route::post('gencreatenumber',  [DebitNoteAjaxController::class, 'genNumberDebitNote']);

        Route::post('customer_list',    [DebitNoteAjaxController::class, 'get_customer']);
        Route::post('searchOrder',      [DebitNoteAjaxController::class, 'searchOrder']);
        Route::post('save_invoice',     [DebitNoteAjaxController::class, 'saveInvoiceDebit']);
        Route::post('cancel_invoice',   [DebitNoteAjaxController::class, 'cancelInvoice']);
        Route::post('search_invoice',   [DebitNoteAjaxController::class, 'searchInvoice']);
        Route::post('getorderlist',     [DebitNoteAjaxController::class, 'getOrderList']);
    });

    Route::prefix('exchange-export')->name('exchange-export')->group(function () {
        Route::post('search', [ExchangeExportAjaxController::class, 'search'])->name('search');
        Route::post('update', [ExchangeExportAjaxController::class, 'update'])->name('update');
    });

    Route::prefix('debitnote_ranchtran_export')->group(function(){
        Route::post('getdebitnote',           [DebitNoteExportAjaxController::class, 'getDebitNoteList']);
        Route::post('gencreatenumber'       , [DebitNoteExportAjaxController::class,'genNumberDebitNote']);
        Route::post('customer_list'         , [DebitNoteExportAjaxController::class,'get_customer']);
        Route::post('searchOrder'           , [DebitNoteExportAjaxController::class,'searchOrder']);
        Route::post('save_invoice'          , [DebitNoteExportAjaxController::class,'saveInvoiceDebit']);
        Route::post('cancel_invoice'        , [DebitNoteExportAjaxController::class,'cancelInvoice']);
        Route::post('search_invoice'        , [DebitNoteExportAjaxController::class,'searchInvoice']);
        Route::post('getorderlist'          , [DebitNoteExportAjaxController::class,'getOrderList']);
    });

});

Route::prefix('order/approveprepare')->name('order.approveprepare')->group(function () {
    Route::get('/', [ApprovePrepareController::class, 'index'])->name('approveprepare.index');
    Route::prefix('print-receipt')->group(function () {
        Route::post('searchreceipt', [PrintReceiptAjaxController::class, 'searchRecreipt']);
        Route::post('print_data', [PrintReceiptAjaxController::class, 'print_receipt']);
    });
});

Route::prefix('proforma-invoice')->name('proforma-invoice')->group(function () {
    Route::get('search-pi-number/{number}', [ProformaInvoiceAjaxController::class, 'searchProformaInovoiceNumber'])->name('search.sale.number');
    Route::get('create-proforma-invoice/{number}', [ProformaInvoiceAjaxController::class, 'createProformaInvoice'])->name('create.proforma.invoice');
});

Route::prefix('customers')->name('customers.')->group(function () {

    Route::resource('exports', ExportController::class)->only([
        'index', 'show', 'edit', 'update',
    ]);

    Route::prefix('approves')->name('approves.')->group(function () {
        Route::get('/', [CustomerApprovesController::class, 'index']);
        Route::get('/view/{id}', [CustomerApprovesController::class, 'show'])->name('view');
        Route::get('/send', [CustomerApprovesController::class, 'send']);
        Route::get('/verify', [CustomerApprovesController::class, 'verify']);
        Route::post('/update/{id}', [CustomerApprovesController::class, 'update']);
        Route::post('/reassign/{id}', [CustomerApprovesController::class, 'reassign']);
    });
});

Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('domestics/broker', [DomesticController::class, 'Broker'])->name('domestics-broker');
    Route::resource('domestics', DomesticController::class)->only(['index', 'show', 'create']);
    // Route::get('domestic-detail/{id}', [DomesticController::class, 'SearchDomesticDetail'])->name('search-domestic-detail');
    Route::resource('domestics', DomesticController::class)->only(['index', 'show']);
    // Route::get('domestic-detail/{id}', [DomesticController::class, 'SearchDomesticDetail'])->name('search-domestic-detail');

    Route::get('domestics/detail/{id}', [DomesticController::class, 'show'])->name('detail');
});

Route::prefix('release-credit')->name('release-credit.')->group(function () {
    Route::get('/', [ReleaseCreditController::class, 'index']);
    Route::get('/create', [ReleaseCreditController::class, 'create']);
    Route::post('/update', [ReleaseCreditController::class, 'update'])->name('update');
});

Route::prefix('promotions')->name('promotions.')->group(function () {
    Route::any('/', [PromotionController::class, 'index']);
    Route::get('/search', [PromotionController::class, 'search']);
    Route::get('/copy', [PromotionController::class, 'copy']);
    Route::post('store-header', [PromotionController::class, 'storeHeader'])->name('store-header');
});

Route::resource('foreign-costomer', ForeignCostomerSearchApprove::class)->only([
    'index', 'show', 'edit', 'update',
]);

Route::prefix('postpone-delivery')->name('postpone-delivery.')->group(function () {
    Route::get('/', [PostponeDeliveryController::class, 'index']);
    Route::get('/search', [PostponeDeliveryController::class, 'search']);
});

Route::prefix('auto')->name('auto.')->group(function () {
    Route::get('/postpone-delivery', [AutoController::class, 'postponeDelivery']);
});

Route::prefix('form-order')->group(function () {
    Route::get('/', [FormOrderHeaderController::class, 'index']);
    Route::get('/show/{id}', [FormOrderHeaderController::class, 'show']);
    Route::get('/report/{id}', [FormOrderHeaderController::class, 'report']);
    Route::post('/approve', [FormOrderHeaderController::class, 'approve']);
});

Route::prefix('addition-quota')->group(function () {
    Route::get('/', [AdditionQuotaController::class, 'index'])->name('addition-index');
    Route::get('/approve/step/{id}/{step}', [AdditionQuotaController::class, 'stepone'])->name('addition-quota');
    Route::post('/upload/file', [AdditionQuotaController::class, 'upload'])->name('addition-upload');
    Route::post('/delete/file', [AdditionQuotaController::class, 'filesdelete'])->name('addition-filesdelete');
    Route::post('/approve/step/update', [AdditionQuotaController::class, 'stepupdate'])->name('addition-quota-update');
    Route::get('/download/files/{id}', [AdditionQuotaController::class, 'download'])->name('addition-download');
    Route::post('/save/onprint', [AdditionQuotaController::class, 'onprint'])->name('addition-onprint');
    Route::post('/getDetailSalesDivision', [AdditionQuotaController::class, 'getDetailSalesDivision'])->name('getDetailSalesDivision');
    Route::post('/getDetailAuthorityId1', [AdditionQuotaController::class, 'getDetailAuthorityId1'])->name('getDetailAuthorityId1');
    Route::post('/getDetailAuthorityId2', [AdditionQuotaController::class, 'getDetailAuthorityId2'])->name('getDetailAuthorityId2');
    Route::post('/getDetailAuthorityId3', [AdditionQuotaController::class, 'getDetailAuthorityId3'])->name('getDetailAuthorityId3');
});

Route::prefix('consignment')->group(function () {
    Route::get('/cancel', [ConsignmentController::class, 'cancel'])->name('cancel-consignment');
    Route::post('/canceled', [ConsignmentController::class, 'canceled'])->name('canceled-consignment');
});

Route::prefix('delivery-rate')->group(function () {
    Route::get('/', [DeliveryRateController::class, 'index'])->name('delivery-rate-index');
    Route::get('/service/ptt/call/auto', [DeliveryRateController::class, 'autocallserviceptt'])->name('delivery-rate-service-call');
    Route::get('/service/ptt/call/date/{date}', [DeliveryRateController::class, 'autocallservicepttfromdate'])->name('delivery-rate-service-call');
    Route::post('/getnewoil', [DeliveryRateController::class, 'getnewoil'])->name('delivery-rate-getnewoil');
    Route::post('/store', [DeliveryRateController::class, 'store'])->name('delivery-rate-store');
    Route::post('/count/price/new', [DeliveryRateController::class, 'countpriceoil'])->name('delivery-rate-price-new');
});

Route::prefix('draft-payout')->group(function () {
    Route::get('/', [DraftPayOutController::class, 'index'])->name('draft-payout-index');
    Route::post('/listproduct', [DraftPayOutController::class, 'listProduct'])->name('draft-payout-listproduct');
    Route::post('/storeDraft', [DraftPayOutController::class, 'storeDraft'])->name('draft-payout-storeDraft');
    Route::get('/print/{id}', [DraftPayOutController::class, 'print'])->name('draft-payout-print');
    Route::get('/print/with/{id}', [DraftPayOutController::class, 'printwith'])->name('draft-payout-print-with');
});

Route::prefix('domestic-matching')->group(function () {
    Route::get('/', [PaymentMethodMatchingController::class, 'index'])->name('domestic-matching-index');
    Route::post('/getData', [PaymentMethodMatchingController::class, 'getDataFirsttime'])->name('domestic-matching-getData');
    Route::post('/uploaded', [PaymentMethodMatchingController::class, 'uploaded'])->name('domestic-matching-uploaded');
    Route::post('/upload/deleted', [PaymentMethodMatchingController::class, 'uploaded'])->name('domestic-matching-upload-deleted');
    Route::post('/unmatching', [PaymentMethodMatchingController::class, 'unmatching'])->name('domestic-matching-unmatching');
    Route::post('/matching', [PaymentMethodMatchingController::class, 'matching'])->name('domestic-matching-matching');
    Route::post('/getinvoice', [PaymentMethodMatchingController::class, 'getinvoice'])->name('domestic-matching-getinvoice');
    Route::post('/getamount', [PaymentMethodMatchingController::class, 'getamount'])->name('domestic-matching-getamount');
    // Jay
    Route::post('/upload', [PaymentMethodMatchingController::class, 'fileupload'])->name('domestic-matching-upload');
    Route::post('/files/delete', [PaymentMethodMatchingController::class, 'filesdelete'])->name('domestic-matching-delete');
    Route::get('/download/files/{id}', [PaymentMethodMatchingController::class, 'download'])->name('domestic-matching-download');
});

Route::prefix('payment-method')->group(function () {
    Route::get('/{type}', [PaymentMethodController::class, 'index'])->name('payment-method-index');
    Route::get('/{type}/{id}', [PaymentMethodController::class, 'print'])->name('payment-method-print');
    Route::post('/getlistbank', [PaymentMethodController::class, 'getBankfromLogic'])->name('payment-method-getlistbank');
    Route::post('/getinfofordraft', [PaymentMethodController::class, 'getinfofordraft'])->name('payment-method-getinfofordraft');
    Route::post('/getvaluebank', [PaymentMethodController::class, 'getvaluebank'])->name('payment-method-getvaluebank');
    Route::post('/getpaymentnumber', [PaymentMethodController::class, 'getPaymentNumber'])->name('payment-method-getpaymentnumber');
    Route::post('/draftpayment', [PaymentMethodController::class, 'draftpayment'])->name('payment-method-draftpayment');
    Route::post('/payment', [PaymentMethodController::class, 'payment'])->name('payment-method-payment');
    Route::post('/payment/upload', [PaymentMethodController::class, 'paymentupload'])->name('payment-method-payment-upload');
    Route::post('/payment/files/delete', [PaymentMethodController::class, 'filesdelete'])->name('payment-method-payment-delete');
    Route::post('/getvaluefromnumber', [PaymentMethodController::class, 'getvaluefromnumber'])->name('payment-method-getvaluefromnumber');
    Route::post('/paymentverify', [PaymentMethodController::class, 'paymentverify'])->name('payment-method-paymentverify');
    // Route::post('/upload-attachment-multiple', [PaymentMethodController::class, 'uploadAttachmentMultiple'])->name('payment-method-payment-upload');
    Route::get('/remove-attachment/{id}', [PaymentMethodController::class, 'removeAttachmentFile'])->name('payment-method-payment-upload-remove');
    Route::get('/download/files/{id}', [PaymentMethodController::class, 'download'])->name('payment-method-download');
    Route::post('/payment/unmatchall', [PaymentMethodController::class, 'unmatchall'])->name('payment-method-unmatchall');
    Route::post('/payment/matchsave', [PaymentMethodController::class, 'matchsave'])->name('payment-method-matchsave');
});

Route::prefix('export-payout')->group(function () {
    Route::get('/', [ExportPaymentMethodController::class, 'index'])->name('export-payout-index');
    Route::post('/getlistbank', [ExportPaymentMethodController::class, 'getBankfromLogic'])->name('export-payout-getlistbank');
    Route::post('/getvaluebank', [ExportPaymentMethodController::class, 'getvaluebank'])->name('export-payout-getvaluebank');
    Route::post('/getpaymentnumber', [ExportPaymentMethodController::class, 'getPaymentNumber'])->name('export-payout-getpaymentnumber');
    Route::post('/draftpayment', [ExportPaymentMethodController::class, 'draftpayment'])->name('export-payment-method-draftpayment');
    Route::post('/payment/files/delete', [ExportPaymentMethodController::class, 'filesdelete'])->name('export-method-payment-delete');
    Route::post('/payment', [ExportPaymentMethodController::class, 'payment'])->name('export-method-payment');
    Route::get('/print/{id}', [ExportPaymentMethodController::class, 'print'])->name('export-method-print');
    Route::post('/getinfofordraft', [ExportPaymentMethodController::class, 'getinfofordraft'])->name('export-method-getinfofordraft');
    Route::post('/getvaluefromnumber', [ExportPaymentMethodController::class, 'getvaluefromnumber'])->name('export-method-getvaluefromnumber');
    Route::post('/payment/upload', [ExportPaymentMethodController::class, 'paymentupload'])->name('export-method-payment-upload');
    Route::post('/payment/matchsave', [ExportPaymentMethodController::class, 'matchsave'])->name('export-method-matchsave');
    Route::post('/payment/unmatchall', [ExportPaymentMethodController::class, 'unmatchall'])->name('export-method-unmatchall');
});

Route::prefix('export-matching')->group(function () {
    Route::get('/', [ExportPaymentMethodMatchingController::class, 'index'])->name('export-matching-index');
    Route::post('/unmatching', [ExportPaymentMethodMatchingController::class, 'unmatching'])->name('export-matching-unmatching');
    Route::post('/uploaded', [ExportPaymentMethodMatchingController::class, 'uploaded'])->name('export-matching-uploaded');
    Route::post('/upload/deleted', [ExportPaymentMethodMatchingController::class, 'filesdelete'])->name('export-matching-upload-deleted');
    Route::post('/getData', [ExportPaymentMethodMatchingController::class, 'getDataFirsttime'])->name('export-matching-getData');
    Route::post('/matching', [ExportPaymentMethodMatchingController::class, 'matching'])->name('export-matching-matching');
    Route::post('/getinvoice', [ExportPaymentMethodMatchingController::class, 'getinvoice'])->name('export-matching-getinvoice');
    Route::post('/getamount', [ExportPaymentMethodMatchingController::class, 'getamount'])->name('export-matching-getamount');
    Route::post('/getDataexchangerate', [ExportPaymentMethodMatchingController::class, 'getDataexchangerate'])->name('export-matching-getDataexchangerate');
});
Route::prefix('tax-adjust')->group(function () {
    Route::get('/', [TaxAdjustmentController::class, 'index_v2'])->name('tax-adjust-index');
    Route::post('/recivedata', [TaxAdjustmentController::class, 'recivedata_v2'])->name('tax-adjust-recivedata');
    Route::post('/senddata', [TaxAdjustmentController::class, 'senddata'])->name('tax-adjust-senddata');
    Route::post('/savedata', [TaxAdjustmentController::class, 'savedata'])->name('tax-adjust-savedata');
});


Route::prefix('transfer-commission')->group(function () {
    Route::get('/', [TransferCommissionController::class, 'index'])->name('index-transfer-commission');
    Route::post('/sndAP', [TransferCommissionController::class, 'sendAP'])->name('sendap-transfer-commission');
    Route::post('/update', [TransferCommissionController::class, 'updateConsignemtn'])->name('update-consignment-commission');
});

Route::prefix('transfer-province')->group(function () {
    Route::get('/', [TransferProvinceController::class, 'index'])->name('index-transfer-province');
    Route::post('/calculate', [TransferProvinceController::class, 'calculate'])->name('calculate-transfer-province');
});

Route::prefix('close-flag')->group(function () {
    Route::get('/{type}', [ClosedFlagSaleController::class, 'index'])->name('close-flag-index');
    Route::post('/release', [ClosedFlagSaleController::class, 'release'])->name('close-flag-release');
    Route::post('/process', [ClosedFlagSaleController::class, 'process'])->name('close-flag-process');
    Route::post('/export/report', [ClosedFlagSaleController::class, 'reportExport'])->name('close-flag-report-export');
    Route::post('/export/process', [ClosedFlagSaleController::class, 'processExport'])->name('close-flag-process-export');
    Route::post('/export/process-so', [ClosedFlagSaleController::class, 'processSOExport'])->name('close-flag-process-so-export');
    Route::post('/export/process-rma', [ClosedFlagSaleController::class, 'processRMAExport'])->name('close-flag-process-rma-export');
    Route::post('/export/process-invoice', [ClosedFlagSaleController::class, 'processInvoiceExport'])->name('close-flag-process-invoice-export');
});

Route::prefix('closed-flag-payment')->group(function () {
    Route::get('/{type}', [ClosedFlagPaymentController::class, 'index'])->name('closed-flag-payment-index-type');
});

Route::prefix('transfer-bi-weekly')->name('transfer-bi-weekly.')->group(function () {
    Route::prefix('domestic')->group(function () {
        Route::get('', [TransferBiWeeklyController::class, 'index']);
        Route::get('approved', [TransferBiWeeklyController::class, 'approved']);
        Route::get('files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            $path = storage_path() . '/app//' . $data->log_directory . '/' . $file_name;

            if (file_exists($path)) {
                return Storage::disk('local')->download($data->log_directory . '/' . $file_name);
            }
        });
        Route::get('files-template', function () {
            return Storage::disk('local')->download('/WBP0001/Import/Template/ตัวอย่าง_ประมาณการรายปักษ์.xlsx');
        });
    });
});

Route::prefix('monthly-distribute')->group(function () {
    Route::prefix('domestic')->group(function () {
        Route::get('', [MonthlyDistributeController::class, 'index']);
        Route::get('approved', [MonthlyDistributeController::class, 'approved']);

        Route::get('files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            $path = storage_path() . '/app//' . $data->log_directory . '/' . $file_name;

            if (file_exists($path)) {
                return Storage::disk('local')->download($data->log_directory . '/' . $file_name);
            }
        });
        Route::get('files-template', function () {
            return Storage::disk('local')->download('/WBP0001/Import/Template/ตัวอย่าง_ประมาณการรายปักษ์.xlsx');
        });
    });
});

Route::resource('overdue-debt', OverdueDebtController::class)->only(['index', 'show']);
Route::resource('sequence-fortnightly', SequenceFortnightlyController::class)->only(['index', 'show']);
Route::resource('biweekly-periods', BiweeklyPeriodsController::class)->only(['index']);

Route::prefix('year-distribute')->group(function () {
    Route::prefix('domestic')->group(function () {
        Route::get('', [YearDistributeController::class, 'index']);
        Route::get('approved', [YearDistributeController::class, 'approved']);

        Route::get('files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            $path = storage_path() . '/app//' . $data->log_directory . '/' . $file_name;

            if (file_exists($path)) {
                return Storage::disk('local')->download($data->log_directory . '/' . $file_name);
            }
        });
    });
});

Route::prefix('transfer-monthly')->name('transfer-monthly.')->group(function () {
    Route::prefix('domestic')->group(function () {
        Route::get('', [TransferMonthlyController::class, 'index']);

        Route::get('files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            $path = storage_path() . '/app//' . $data->log_directory . '/' . $file_name;

            if (file_exists($path)) {
                return Storage::disk('local')->download($data->log_directory . '/' . $file_name);
            }
        });
    });
});

Route::get('transfer-bi-weekly-export', [TranferBiWeeklyExportController::class, 'approved']);
Route::get('monthly-distribute-export', [MonthlyDistributeExportController::class, 'approved']);
Route::get('year-distribute-export', [YearDistributeExportController::class, 'approved']);

Route::get('reprint-invoice', [ReprintInvoiceController::class, 'index']);
Route::get('print-invoice', [PrintInvoiceController::class, 'index']);
Route::get('print-invoice/report', [PrintInvoiceController::class, 'print_invoice']);
Route::get('prepare-saleorder', [PrepareSaleOrderController::class, 'index']);
Route::get('prepare-saleorder/{number}', [PrepareSaleOrderController::class, 'index'])->name('prepare-saleorder.omp0020');
Route::get('prepare-saleorder/print/report',   [PrepareSaleOrderController::class, 'printReport']);
Route::get('approve-saleorder', [ApproveSaleOrderController::class, 'index']);

Route::get('print-invoice/report-all', [PrintInvoiceController::class, 'print_invoice_all'])->name('print-invoice.report-all');

Route::prefix('order/approveprepara')->name('order.approveprepara')->group(function () {
    Route::get('/', [ApprovePrepareController::class, 'index'])->name('approveprepara.index');
});

Route::prefix('order/prepare')->name('order.prepare.')->group(function () {
    Route::get('/', [PrepareOrderController::class, 'index'])->name('order');
    Route::get('/search', [PrepareOrderController::class, 'search'])->name('search');
    Route::get('/create', [PrepareOrderController::class, 'showcreate'])->name('create.show');
    Route::get('/edit/{id}', [PrepareOrderController::class, 'showedit'])->name('prepare.edit');
    Route::post('/edit/{id}/submit', [PrepareOrderController::class, 'editsubmit']);
    Route::post('/create/submit', [PrepareOrderController::class, 'create'])->name('create.submit');
    Route::post('/update/submit', [PrepareOrderController::class, 'update'])->name('update.submit');
    Route::get('/approve/{id}', [PrepareOrderController::class, 'approve'])->name('approve');
    Route::post('/cancel/{id}', [PrepareOrderController::class, 'cancel'])->name('cancel');
    Route::get('/copy/{id}', [PrepareOrderController::class, 'copy'])->name('copy');
    Route::get('/direct_debit', [PrepareOrderController::class, 'direct_debit'])->name('direct_debit');

    Route::get('/report_order', [PrepareOrderController::class, 'report_order'])->name('report_order');
    Route::get('/report_preparation', [PrepareOrderController::class, 'report_preparation'])->name('report_preparation');

});

Route::prefix('order/approve')->name('order.approve')->group(function () {
    Route::get('/', 'App\Http\Controllers\OM\ApproveOrderController@index')->name('approve.index');
});

Route::get('/test', [InvoiceController::class, 'index']);
Route::get('test', [InvoiceController::class, 'getInvoiceHeader'])->name('get-invoice-header');
Route::get('test/save', [InvoiceController::class, 'printInvoice'])->name('get-invoice-header-save');

Route::prefix('print-receipt')->group(function () {
    Route::get('reprint',       [ReprintReceiptController::class, 'index']);
    Route::get('print',         [PrintReceiptController::class, 'index']);
    Route::get('print-content', [PrintReceiptController::class, 'print_page_pdf']);
});
Route::resource('overdue-debt', OverdueDebtController::class)->only(['index', 'show']);
Route::resource('sale-confirmation', SaleConfirmationController::class)->only(['index']);
Route::get('/sale-confirmation/print', [SaleConfirmationController::class, 'print'])->name('print');
Route::resource('sequence-fortnightly', SequenceFortnightlyController::class)->only(['index', 'show']);
Route::resource('biweekly-periods', BiweeklyPeriodsController::class)->only(['index']);
Route::resource('proforma-invoice', ProformaInvoiceController::class)->only(['index']);
Route::get('/proforma-invoice/print', [ProformaInvoiceController::class, 'print'])->name('print');
Route::get('/proforma-invoice/print-in', [ProformaInvoiceController::class, 'printIn'])->name('print-in');
Route::resource('tax-invoice-export', TaxInvoiceExportController::class)->only(['index']);
Route::get('/tax-invoice-export/print-invoice', [TaxInvoiceExportController::class, 'printinvoice'])->name('print-invoice');
Route::get('/tax-invoice-export/print-packing-list', [TaxInvoiceExportController::class, 'printpackinglist'])->name('print-packing-list');

Route::prefix('approve-sale-confirmation')->group(function () {
    Route::get('/', [ApproveSaleConfirmationController::class, 'index']);
});
Route::prefix('transpot-report')->group(function () {
    Route::get('/', [TranspotReportController::class, 'index'])->name('transpot-report-index');
    Route::post('/draftData', [AjexTranspotReportController::class, 'draftData'])->name('transpot-report-draftData');
    Route::post('/createDataone', [AjexTranspotReportController::class, 'createDataone'])->name('transpot-report-createDataone');
    Route::post('/createDatatwo', [AjexTranspotReportController::class, 'createDatatwo'])->name('transpot-report-createDatatwo');
    Route::post('/createDatathree', [AjexTranspotReportController::class, 'createDatathree'])->name('transpot-report-createDatathree');
    Route::post('/createDataToAP', [AjexTranspotReportController::class, 'createDataToAP'])->name('transpot-report-createDataToAP');
    Route::get('/print', [AjexTranspotReportController::class, 'print'])->name('transpot-report-print');
    Route::get('/print_1', [AjexTranspotReportController::class, 'print_1'])->name('transpot-report-print-1');
    Route::get('/print_2', [AjexTranspotReportController::class, 'print_2'])->name('transpot-report-print-2');
    Route::get('/print_3', [AjexTranspotReportController::class, 'print_3'])->name('transpot-report-print-3');
    Route::get('/print_4', [AjexTranspotReportController::class, 'print_4'])->name('transpot-report-print-4');
});

Route::prefix('invoice')->group(function () {
    Route::get('/', [InvoiceController::class, 'getInvoiceHeader'])->name('get-invoice-header');
    Route::get('/save', [InvoiceController::class, 'printInvoice'])->name('get-invoice-header-save');
});

Route::prefix('cancel-invoice')->group(function () {
    Route::get('', [CancelInvoiceController::class, 'index']);
});
Route::prefix('order-direct-debit')->name('order.direct.debit')->group(function () {
    Route::prefix('export')->group(function () {
        Route::get('/', [OrderDirectDebitController::class, 'index']);
        Route::post('/save', [OrderDirectDebitController::class, 'exportSave']);
        Route::get('/file-tranfer', [OrderDirectDebitController::class, 'exportFileTranfer']);
        // Route::post('/create-file-tranfer', [OrderDirectDebitController::class, 'domesticCreateFileTranfer']);
        // Route::get('/create-ttb', [OrderDirectDebitController::class, 'domesticCreateTTBFileTranfer']);
        Route::post('/prepare-file-tranfer', [OrderDirectDebitController::class, 'prepareFileTranferExport']);
        Route::post('/confirm-file/{batch_no}', [OrderDirectDebitController::class, 'confirmFileExport']);
        Route::get('download_files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            return Storage::disk('local')->download($data->archive_directory . '/' . $file_name);
        });
    });

    Route::prefix('domestic')->group(function () {
        Route::get('/', [OrderDirectDebitController::class, 'domestic']);
        Route::get('/file-tranfer', [OrderDirectDebitController::class, 'domesticFileTranfer']);
        Route::post('/create-file-tranfer', [OrderDirectDebitController::class, 'domesticCreateFileTranfer']);
        Route::get('/create-ttb', [OrderDirectDebitController::class, 'domesticCreateTTBFileTranfer']);
        Route::post('/search', [OrderDirectDebitController::class, 'searchDirectDabit']);
        Route::post('/prepare-file-tranfer', [OrderDirectDebitController::class, 'prepareFileTranfer']);
        Route::post('/save', [OrderDirectDebitController::class, 'domesticSave']);
        Route::post('/confirm-file/{batch_no}', [OrderDirectDebitController::class, 'confirmFile']);
        Route::get('download_files/{file_name}', function ($file_name = null) {
            $data = getDefaultData('/users');
            return Storage::disk('local')->download($data->archive_directory . '/' . $file_name);
        });
        Route::get('/download-transfer-debit', [OrderDirectDebitController::class, 'downloadTransferDebit'])->name('download-transfer-debit');
    });

    Route::get('/sa-by-customer/{customer}', [OrderDirectDebitController::class, 'saByCustomer']);
});
Route::prefix('consignment')->name('consignment')->group(function () {

    //Route to blank form
    Route::get('/', [App\Http\Controllers\OM\ConsignmentController::class, 'init']);

    //Route for fill new Consignment number
    Route::get('/create', [App\Http\Controllers\OM\ConsignmentController::class, 'get'])->name('getData');

    Route::get('/searchPickRelease/{release_num}', [App\Http\Controllers\OM\ConsignmentController::class, 'searchPickReleaseNum']);
    Route::get('/vatAmount/{customer_id}', [App\Http\Controllers\OM\ConsignmentController::class, 'vatAmount']);
    Route::get('/line/{order_header_id}', [App\Http\Controllers\OM\ConsignmentController::class, 'line']);
    Route::get('/getPrevSave/{order_header_id}/{item_id}', [App\Http\Controllers\OM\ConsignmentController::class, 'getPrevSave']);
    Route::post('/save/{action}', [App\Http\Controllers\OM\ConsignmentController::class, 'saveLines']);
    Route::get('/searchConsignmentData/{search_consignment_id}/{search_consignment_date}/{search_pick_release_id}/{search_pick_release_date}/{search_customer_id}/{search_customer_name}/{search_status}', [App\Http\Controllers\OM\ConsignmentController::class, 'searchConsignmentData']);
    Route::post('/fillData', [App\Http\Controllers\OM\ConsignmentController::class, 'fillData']);
});

Route::prefix('invoice')->name('invoice.')->group(function () {
    Route::get('/cancel', [InvoiceController::class, 'cancel'])->name('cancel-invoice');
    Route::post('/canceled', [InvoiceController::class, 'actionCancel'])->name('canceled-invoice');
    Route::get('/list-cancel-invoice', [InvoiceController::class, 'getAjaxListCancelInvoice'])->name('getlist-cancel-invoice');
});

Route::resource('consignment-club', ConsignmentClubController::class)->only(['index', 'show']);
Route::post('upload-attachment-multiple', [AttachmentController::class, 'uploadAttachmentMultiple']);
Route::get('remove-attachment/{id}', [AttachmentController::class, 'removeAttachmentFile']);
Route::resource('approve-prepare', ApprovePrepareOrderController::class)->only(['index', 'show']);
Route::resource('rma-export', RmaExportController::class)->only(['index', 'show']);
Route::resource('exchange-export', ExchangeExportController::class)->only(['index', 'show']);

// Route::resource('approve-prepare', ApprovePrepareOrderController::class)->only(['index', 'show']);

Route::prefix('transfer-bank')->name('promotions.')->group(function () {
    Route::get('/domestic', [TransferFileBankController::class, 'domestic']);
});
Route::get('credit-note-ranch-transfer'                           , [CreditNoteRanchTransferController::class,'index']);
Route::get('credit-note-other'                                    , [CreditNoteOtherController::class,'index']);
Route::get('debit-note'                                           , [DebitNoteController::class,'index']);
Route::get('debit-note/report'                                    , [DebitNoteController::class,'report']);
Route::get('debit-note-export'                                    , [DebitNoteExportController::class,'index']);
Route::get('debit-note-export/report'                             , [DebitNoteExportController::class,'report']);
Route::get('credit-note-other-export'                             , [CreditNoteExportOtherController::class,'index']);
Route::get('credit-note-other-export-report'                      , [CreditNoteExportOtherController::class,'creditExport']);

Route::resource('rma-export', RmaExportController::class)->only(['index', 'show']);
Route::prefix('approve-prepare')->name('approve-prepare.')->group(function () {
    Route::get('print/{id}', [ApprovePrepareOrderController::class, 'print'])->name('print');
    Route::get('calpao/{id}', [ApprovePrepareOrderController::class, 'calpao'])->name('calpao');
});

// Route::prefix('sale-confirmation')->name('sale-confirmation.')->group(function () {
//     Route::get('print/{id}', [SaleConfirmationController::class, 'print'])->name('print');
// });


Route::prefix('pao-tax-mt')->name('pao-tax-mt.')->group(function () {
    Route::get('/', [PaoTaxMtController::class, 'index'])->name('index');
    Route::get('search', [PaoTaxMtController::class, 'search'])->name('search');
    Route::post('validate', [PaoTaxMtController::class, 'validateData'])->name('validate');
    Route::post('store', [PaoTaxMtController::class, 'store'])->name('store');
    Route::patch('update', [PaoTaxMtController::class, 'update'])->name('update');
    Route::get('ex-report', [PaoTaxMtController::class, 'exReport'])->name('ex-report');
    Route::post('interface', [PaoTaxMtController::class, 'interface'])->name('interface');
    Route::post('send-gl', [PaoTaxMtController::class, 'sendGL'])->name('send-gl');
    Route::post('remove', [PaoTaxMtController::class, 'remove'])->name('remove');
    Route::post('delete', [PaoTaxMtController::class, 'delete'])->name('delete');
});

Route::prefix('transfer-txt-to-bank')->name('transfer-txt-to-bank.')->group(function () {
    Route::get('/', [TransferTxtToBankController::class, 'index']);
    Route::get('/pdf', [TransferTxtToBankController::class, 'pdf']);
    Route::get('/txt', [TransferTxtToBankController::class, 'txt']);
    Route::get('/customer-list', [TransferTxtToBankController::class, 'getCustomer']);
});

Route::prefix('close-daily-sale')->name('close-daily-sale.')->group(function () {
    Route::get('/', [CloseDailySaleController::class, 'index']);
    Route::get('/date-lists', [CloseDailySaleController::class, 'getDateLists']);
    Route::get('/document-no-lists', [CloseDailySaleController::class, 'getDocumentNoLists']);
    // Route::get('/call-report', [CloseDailySaleController::class, 'callReport']);
    Route::post('/call-report', [CloseDailySaleController::class, 'callReport']);
    Route::post('/validate-data', [CloseDailySaleController::class, 'validateData']);
    Route::post('/interface/process-cons', [CloseDailySaleController::class, 'processCons']);
    Route::post('/interface/process-so', [CloseDailySaleController::class, 'processSO']);
    Route::post('/interface/process-rma', [CloseDailySaleController::class, 'processRMA']);
    Route::post('/interface/process-invoice', [CloseDailySaleController::class, 'processInvoice']);
    Route::post('/interface/process-gl', [CloseDailySaleController::class, 'processGL']);
    // Route::get('/interface', [CloseDailySaleController::class, 'interface']);
});

Route::prefix('/close-daily-payoff')->name('close-daily-payoff.')->group(function () {

    Route::prefix('export')->group(function () {
        Route::get('/', [CloseDailyPayoffController::class, 'export']);
        // Route::get('/date-lists', [CloseDailyPayoffController::class, 'getDateLists']);
        Route::post('/date-lists', [CloseDailyPayoffController::class, 'getDateLists']);
        // Route::get('/call-report', [CloseDailySaleController::class, 'callReport']);
        Route::post('/call-report', [CloseDailyPayoffController::class, 'callReport']);
        Route::post('/validate-data', [CloseDailyPayoffController::class, 'validateData']);
        Route::post('/interface', [CloseDailyPayoffController::class, 'interface']);
        // Route::get('/interface', [CloseDailyPayoffController::class, 'interface']);
    });

    Route::prefix('domestic')->group(function () {
        Route::get('/', [CloseDailyPayoffController::class, 'domestic']);
        // Route::get('/date-lists', [CloseDailyPayoffController::class, 'getDateLists']);
        Route::post('/date-lists', [CloseDailyPayoffController::class, 'getDateLists']);
        // Route::get('/call-report', [CloseDailyPayoffController::class, 'callReport']);
        Route::post('/call-report', [CloseDailyPayoffController::class, 'callReport']);
        Route::post('/validate-data', [CloseDailyPayoffController::class, 'validateData']);
        Route::post('/interface', [CloseDailyPayoffController::class, 'interface']);
        // Route::get('/interface', [CloseDailyPayoffController::class, 'interface']);
    });
});

Route::resource('consignment-bkk', ConsignmentBkkController::class)->only(['index', 'store']);
Route::prefix('consignment-bkk')->name('consignment-bkk')->group(function () {
    Route::post('attach', [ConsignmentBkkController::class, 'attach'])->name('consignment.bkk.attach');
    Route::get('get-order-header', [ConsignmentBkkController::class, 'getOrderHeader'])->name('consignment.bkk.get-order-header');
    Route::get('get-consignment', [ConsignmentBkkController::class, 'getConsignment'])->name('consignment.bkk.get-consignment');
    Route::get('get-customer', [ConsignmentBkkController::class, 'getCustomer'])->name('consignment.bkk.get-customer');
});

Route::resource('cut-stock-inventory', CutStockInventoryController::class)->only(['index', 'store']);
Route::prefix('cut-stock-inventory')->name('cut-stock-inventory')->group(function () {
    Route::get('get-account-list', [CutStockInventoryController::class, 'getAccountList'])->name('cut-stock-inventory.get-account-list');
    Route::get('get-invoice-list', [CutStockInventoryController::class, 'getInvoiceList'])->name('cut-stock-inventory.get-invoice-list');
    Route::get('get-invoice-lines', [CutStockInventoryController::class, 'getInvoiceLines'])->name('cut-stock-inventory.get-invoice-lines');
});

Route::resource('product-return', ProductReturnController::class)->only(['index', 'store']);
Route::prefix('product-return')->name('product-return')->group(function () {
    Route::get('get-inv-list', [ProductReturnController::class, 'getInvList'])->name('product-return.get-inv-list');
    Route::get('get-sub-inv-list', [ProductReturnController::class, 'getSubInvList'])->name('product-return.get-sub-inv-list');
    Route::get('get-locate-seg1-list', [ProductReturnController::class, 'getLocateSeg1List'])->name('product-return.get-locate-seg1-list');
    Route::get('get-locate-seg2-list', [ProductReturnController::class, 'getLocateSeg2List'])->name('product-return.get-locate-seg2-list');
    Route::get('get-lot-number-list', [ProductReturnController::class, 'getLotNumberList'])->name('product-return.get-lot-number-list');
    Route::get('get-account-list', [ProductReturnController::class, 'getAccountList'])->name('product-return.get-account-list');
    Route::get('get-rma-list', [ProductReturnController::class, 'getRmaList'])->name('product-return.get-rma-list');
    Route::get('get-rma-lines', [ProductReturnController::class, 'getRmaLines'])->name('product-return.get-rma-lines');
});

Route::resource('pao-percent', PaoPercentController::class)->only(['index', 'store']);
Route::prefix('pao-percent')->name('pao-percent')->group(function () {
    Route::get('get-customer-list', [PaoPercentController::class, 'getCustomerList'])->name('pao-percent.get-customer-list');
    Route::get('get-data-customer', [PaoPercentController::class, 'getDataCustomer'])->name('pao-percent.get-data-customer');
    Route::get('get-province-list', [PaoPercentController::class, 'getProvinceList'])->name('pao-percent.get-province-list');
});
