<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IE\Settings\LocationController;
use App\Http\Controllers\IE\Settings\CategoriesController;
use App\Http\Controllers\IE\Settings\SubCategoryController;
use App\Http\Controllers\IE\Settings\SubCategoryInfoController;
use App\Http\Controllers\IE\Settings\CACategoriesController;
use App\Http\Controllers\IE\Settings\CASubCategoryController;
use App\Http\Controllers\IE\Settings\CASubCategoryInfoController;
use App\Http\Controllers\IE\Settings\PolicyController;
use App\Http\Controllers\IE\Settings\PolicyRateController;
use App\Http\Controllers\IE\Settings\PreferenceController;
use App\Http\Controllers\IE\Settings\UserAccountController;
use App\Http\Controllers\IE\Settings\HierarchyController;
use App\Http\Controllers\IE\Settings\HierarchyTopicController;
use App\Http\Controllers\IE\Settings\HierarchyTypeController;
use App\Http\Controllers\IE\Settings\HierarchyPositionController;
use App\Http\Controllers\IE\Settings\HierarchyPositionUserController;
use App\Http\Controllers\IE\Settings\HierarchyNameController;
use App\Http\Controllers\IE\Settings\HierarchyNamePositionController;
use App\Http\Controllers\IE\Settings\HierarchySetupController;
use App\Http\Controllers\IE\Settings\HierarchyLinesController;
use App\Http\Controllers\IE\Settings\HierarchyLineUsersController;
use App\Http\Controllers\IE\Ajax\IconController;

use App\Http\Controllers\IE\CashAdvanceController;
use App\Http\Controllers\IE\ReimbursementController;
use App\Http\Controllers\IE\ReceiptController;
use App\Http\Controllers\IE\ReceiptLineController;
use App\Http\Controllers\IE\AttachmentsController;
use App\Http\Controllers\IE\DFFController;
use App\Http\Controllers\IE\ReportController;

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
    Route::get('icon/', [IconController::class, 'index'])->name("icon.index");
});

    /////////////////////
    //// CASH-ADVANCE
    Route::prefix('cash-advances')->name('cash-advances.')->group(function () {
        Route::get('/check_gl_period', [CashAdvanceController::class, 'checkGLPeriod'])->name('check_gl_period');
        Route::post('return_encumbrance', [CashAdvanceController::class, 'returnEncumbrance'])->name('return_encumbrance');
        Route::get('/get_suppliers', [CashAdvanceController::class, 'getSuppliers'])->name('get_suppliers');
        Route::get('/get_supplier_sites', [CashAdvanceController::class, 'getSupplierSites'])->name('get_supplier_sites');
        Route::get('/get_supplier_bank_detail', [CashAdvanceController::class, 'getSupplierBankDetail'])->name('get_supplier_bank_detail');
        Route::get('/get_requester_data', [CashAdvanceController::class, 'getRequesterData'])->name('get_requester_data');

        Route::get('/pending', [CashAdvanceController::class, 'indexPending'])->name('index-pending');
        Route::get('/get_sub_categories', [CashAdvanceController::class, 'getSubCategories'])->name('get_sub_categories');
        Route::get('/ca_sub_category/{ca_sub_category}/get_form_informations', [CashAdvanceController::class, 'getInputFormInformations'])->name('get_form_informations');

        Route::resource('/', CashAdvanceController::class)->only([
            'index', 'create', 'update', 'show'
        ])->parameters(['' => 'cashAdvance']);

        Route::post('store', [CashAdvanceController::class, 'store'])->name('store');
        Route::post('export', [CashAdvanceController::class, 'export'])->name('export');

        Route::prefix('{cashAdvance}')->group(function () {

            Route::get('/get_hierarchies', [CashAdvanceController::class, 'getHierarchies'])->name('get_hierarchies');
            Route::get('/get_hierarchy_user_lists', [CashAdvanceController::class, 'getHierarchyUserLists'])->name('get_hierarchy_user_lists');
            Route::get('/form_send_request', [CashAdvanceController::class, 'formSendRequest'])->name('form_send_request');

            Route::get('/list_cancel_apply', [CashAdvanceController::class, 'listCancelApply'])->name('list_cancel_apply');
            Route::patch('update_cl', [CashAdvanceController::class, 'updateCL'])->name('update_cl');
            Route::post('reapply', [CashAdvanceController::class, 'reapply'])->name('reapply');
            Route::get('/form_edit', [CashAdvanceController::class, 'formEdit'])->name('form_edit');
            Route::get('/form_edit_cl', [CashAdvanceController::class, 'formEditCL'])->name('form_edit_cl');
            route::get('/report', [CashAdvanceController::class, 'report'])->name('report');
            Route::get('/get_total_amount', [CashAdvanceController::class, 'getTotalAmount'])->name('get_total_amount');

            Route::patch('/update_dff', [CashAdvanceController::class, 'updateDFF'])->name('update_dff');
            Route::post('/change_approver', [CashAdvanceController::class, 'changeApprover'])->name('change_approver');
            Route::post('/set_status', [CashAdvanceController::class, 'setStatus'])->name('set_status');
            Route::post('/add_attachment', [CashAdvanceController::class, 'addAttachment'])->name('add_attachment');
            Route::post('/set_due_date', [CashAdvanceController::class, 'setDueDate'])->name('set_due_date');

            Route::get('/get_diff_ca_and_clearing_amount', [CashAdvanceController::class, 'getDiffCAAndClearingAmount'])->name('get_diff_ca_and_clearing_amount');
            Route::get('get_diff_ca_and_clearing_data', [CashAdvanceController::class, 'getDiffCAAndClearingData'])->name('get_diff_ca_and_clearing_data');

            Route::post('/duplicate', [CashAdvanceController::class, 'duplicate'])->name('duplicate');

            Route::get('/clear-request', [CashAdvanceController::class, 'clearRequest'])->name('clear-request');
            Route::get('/clear', [CashAdvanceController::class, 'clear'])->name('clear');

            Route::post('/check_ca_attachment', [CashAdvanceController::class, 'checkCAAttachment'])->name('check_ca_attachment');
            Route::post('/check_ca_min_amount', [CashAdvanceController::class, 'checkCAMinAmount'])->name('check_ca_min_amount');
            Route::post('/check_ca_max_amount', [CashAdvanceController::class, 'checkCAMaxAmount'])->name('check_ca_max_amount');

            Route::post('/combine_receipt_gl_code_combination', [CashAdvanceController::class, 'combineReceiptGLCodeCombination'])->name('combine_receipt_gl_code_combination');
            Route::post('/check_over_budget', [CashAdvanceController::class, 'checkOverBudget'])->name('check_over_budget');
            Route::post('/check_exceed_policy', [CashAdvanceController::class, 'checkExceedPolicy'])->name('check_exceed_policy');

            Route::post('/validate_receipt', [CashAdvanceController::class, 'validateReceipt'])->name('validate_receipt');

            Route::get('/form_send_request_with_reason', [CashAdvanceController::class, 'formSendRequestWithReason'])->name('form_send_request_with_reason');
        });
    });

    /////////////////////
    //// REIMBURSEMENT
    Route::prefix('reimbursements')->name('reimbursements.')->group(function () {
        Route::get('/check_gl_period', [ReimbursementController::class, 'checkGLPeriod'])->name('check_gl_period');
        Route::get('/get_suppliers', [ReimbursementController::class, 'getSuppliers'])->name('get_suppliers');
        Route::get('/get_supplier_sites', [ReimbursementController::class, 'getSupplierSites'])->name('get_supplier_sites');
        Route::get('/get_supplier_bank_detail', [ReimbursementController::class, 'getSupplierBankDetail'])->name('get_supplier_bank_detail');
        Route::get('/get_requester_data', [ReimbursementController::class, 'getRequesterData'])->name('get_requester_data');
        Route::get('/pending', [ReimbursementController::class, 'indexPending'])->name('index-pending');
        
        Route::resource('/', ReimbursementController::class)->only([
            'index', 'create', 'update', 'show'
        ])->parameters(['' => 'reimbursement']);

        Route::post('store', [ReimbursementController::class, 'store'])->name('store');
        Route::post('export', [ReimbursementController::class, 'export'])->name('export');

        Route::prefix('{reimbursement}')->group(function () {

            Route::get('/get_hierarchies', [ReimbursementController::class, 'getHierarchies'])->name('get_hierarchies');
            Route::get('/get_hierarchy_user_lists', [ReimbursementController::class, 'getHierarchyUserLists'])->name('get_hierarchy_user_lists');
            Route::get('/form_send_request', [ReimbursementController::class, 'formSendRequest'])->name('form_send_request');
            Route::get('/form_edit', [ReimbursementController::class, 'formEdit'])->name('form_edit');
            Route::get('/get_total_amount', [ReimbursementController::class, 'getTotalAmount'])->name('get_total_amount');

            Route::patch('/update_dff', [ReimbursementController::class, 'updateDFF'])->name('update_dff');
            Route::post('/change_approver', [ReimbursementController::class, 'changeApprover'])->name('change_approver');
            Route::post('/set_status', [ReimbursementController::class, 'setStatus'])->name('set_status');
            Route::post('/add_attachment', [ReimbursementController::class, 'addAttachment'])->name('add_attachment');
            Route::post('/set_due_date', [ReimbursementController::class, 'setDueDate'])->name('set_due_date');
            Route::post('/duplicate', [ReimbursementController::class, 'duplicate'])->name('duplicate');
            
            Route::post('/combine_receipt_gl_code_combination', [ReimbursementController::class, 'combineReceiptGLCodeCombination'])->name('combine_receipt_gl_code_combination');
            
            Route::post('/check_over_budget', [ReimbursementController::class, 'checkOverBudget'])->name('check_over_budget');
            Route::post('/check_exceed_policy', [ReimbursementController::class, 'checkExceedPolicy'])->name('check_exceed_policy');

            Route::post('/validate_receipt', [ReimbursementController::class, 'validateReceipt'])->name('validate_receipt');
    
            Route::get('/form_send_request_with_reason',[ReimbursementController::class, 'formSendRequestWithReason'])->name('form_send_request_with_reason');
        });


    });

    Route::prefix('receipts')->name('receipts.')->group(function () {

        Route::get('get_inv_tobacco', [ReceiptLineController::class, 'getInvTobacco'])->name('get_inv_tobacco');
        Route::get('/get_vendor_sites/{vendor_id}', [ReceiptController::class, 'getVendorSites'])->name('get_vendor_sites');
        Route::get('/get_vendor_detail/{vendor_id}/site/{vendor_site_code}', [ReceiptController::class, 'getVendorDetail'])->name('get_vendor_detail');
        Route::get('get_rows', [ReceiptController::class, 'getRows'])->name('get_rows');
        Route::get('get_table_total_rows', [ReceiptController::class, 'getTableTotalRows'])->name('get_table_total_rows');
        Route::get('form_create', [ReceiptController::class, 'formCreate'])->name('form_create');
        Route::get('pending', [ReceiptController::class, 'indexPending'])->name('index-pending');

        Route::resource('/', ReceiptController::class)->only([
            'create', 'update', 'show'
        ])->parameters(['' => 'receipt']);

        Route::post('store', [ReceiptController::class, 'store'])->name('store');
        Route::post('export', [ReceiptController::class, 'export'])->name('export');
        Route::post('set_status', [ReceiptController::class, 'set_status'])->name('set_status');
        Route::post('add_attachment', [ReceiptController::class, 'add_attachment'])->name('add_attachment');

        Route::get('/{receipt}/form_edit', [ReceiptController::class, 'formEdit'])->name('form_edit');
        Route::post('/{receipt}/update', [ReceiptController::class, 'update'])->name('update');
        Route::post('/{receipt}/add_attachment', [ReceiptController::class, 'addAttachment'])->name('add_attachment');
        Route::post('/{receipt}/duplicate', [ReceiptController::class, 'duplicate'])->name('duplicate');
        Route::post('/{receipt}/remove', [ReceiptController::class, 'remove'])->name('remove');

        Route::prefix('/{receipt}/lines')->name('lines.')->group(function () {

            Route::post('store', [ReceiptLineController::class, 'store'])->name('store');
            Route::post('/{line}/update', [ReceiptLineController::class, 'update'])->name('update');
            Route::patch('/{line}/update_coa', [ReceiptLineController::class, 'updateCOA'])->name('update_coa');
            Route::patch('/{line}/update_dff', [ReceiptLineController::class, 'updateDFF'])->name('update_dff');
            Route::patch('/{line}/update_dff_distribution', [ReceiptLineController::class, 'updateDFFDistribution'])->name('update_dff_distribution');
            Route::post('/{line}/duplicate', [ReceiptLineController::class, 'duplicate'])->name('duplicate');
            Route::post('/{line}/remove', [ReceiptLineController::class, 'remove'])->name('remove');
            Route::get('/{line}/get_show_infos', [ReceiptLineController::class, 'getShowInfos'])->name('get_show_infos');

            // GET FORM FOR CREATE RECEIPT LINE
            Route::get('/form_create', [ReceiptLineController::class, 'formCreate'])->name('form_create');
            Route::get('/get_sub_categories', [ReceiptLineController::class, 'getSubCategories'])->name('get_sub_categories');
            Route::get('/sub_category/{sub_category}/get_form_informations', [ReceiptLineController::class, 'getInputFormInformations'])->name('sub_category.get_form_informations');
            Route::get('/sub_category/{sub_category}/get_form_amount', [ReceiptLineController::class, 'getInputFormAmount'])->name('sub_category.get_form_amount');

            // GET FORM FOR EDIT COA RECEIPT LINE
            Route::get('/{line}/form_coa', [ReceiptLineController::class, 'formCOA'])->name('form_coa');
            Route::get('/{line}/input_cost_center_code', [SubCategoryController::class, 'inputCostCenterCode'])->name("input_cost_center_code");
            Route::get('/{line}/input_budget_detail_code', [SubCategoryController::class, 'inputBudgetDetailCode'])->name("input_budget_detail_code");
            Route::get('/{line}/input_sub_account_code', [SubCategoryController::class, 'inputSubAccountCode'])->name("input_sub_account_code");
            Route::get('/{line}/validate_combination', [ReceiptLineController::class, 'validateCombination'])->name("validate_combination");

            // GET FORM FOR EDIT RECEIPT LINE
            Route::get('/{line}/form_edit', [ReceiptLineController::class, 'formEdit'])->name('form_edit');
            Route::get('/{line}/get_form_edit_informations', [ReceiptLineController::class, 'getInputFormEditInformations'])->name('get_form_edit_informations');
            Route::get('/{line}/get_form_edit_amount', [ReceiptLineController::class, 'getInputFormEditAmount'])->name('get_form_edit_amount');

        });

    });

    Route::prefix('dff')->name('dff.')->group(function () {
        Route::get('get_form', [DFFController::class, 'getForm'])->name('get_form');
        Route::get('get_form_header', [DFFController::class, 'getFormHeader'])->name('get_form_header');
        Route::get('get_form_line', [DFFController::class, 'getformLine'])->name('get_form_line');
    });

    Route::prefix('attachments')->name('attachments.')->group(function () {
        
        Route::get('/{attachment_id}/download', [AttachmentsController::class, 'download'])->name('download');
        Route::get('/{attachment_id}/image', [AttachmentsController::class, 'image'])->name('image');
        Route::post('/{attachment_id}/image_modal', [AttachmentsController::class, 'image'])->name('image_modal');
        Route::post('/{attachment_id}/remove', [AttachmentsController::class, 'remove'])->name('remove');
        Route::delete('/{attachment_id}/remove', [AttachmentsController::class, 'remove'])->name('remove');

    });

    //////////////
    //// SETTING
    Route::prefix('settings')->name('settings.')->group(function () {

        // Route::post('locations/inactive', [LocationController::class, 'inactive'])->name("locations.inactive");
        Route::resource('locations', LocationController::class)->only([
            'index', 'create', 'edit', 'update'
        ]);

        // REIM Categories
        Route::resource('categories', CategoriesController::class)->only([
            'index', 'create', 'store', 'edit', 'update'
        ]);
        Route::post('categories/{category}/remove', [CategoriesController::class, 'remove'])->name("categories.remove");


        Route::group(['prefix'=>'categories/{category}'], function () {
            // Sub-Categories
            Route::get('sub_categories/validate_combination', [SubCategoryController::class, 'validateCombination'])->name("validate_combination");
            Route::get('sub_categories/form_set_account', [SubCategoryController::class, 'formSetAccount'])->name("form_set_account");
            Route::get('sub_categories/input_cost_center_code/', [SubCategoryController::class, 'inputCostCenterCode'])->name("input_cost_center_code");
            Route::get('sub_categories/input_budget_detail_code/', [SubCategoryController::class, 'inputBudgetDetailCode'])->name("input_budget_detail_code");
            Route::get('sub_categories/input_sub_account_code/', [SubCategoryController::class, 'inputSubAccountCode'])->name("input_sub_account_code");
            Route::resource('sub-categories', SubCategoryController::class);
            Route::group(['prefix'=>'sub-categories/{sub_category}'], function () {

                // Sub-Categories Info.
                Route::group(['as'=>'sub-categories.'], function () {
                    Route::resource('infos', SubCategoryInfoController::class);
                    Route::get('/input_form_type/{input_form_type}', [SubCategoryInfoController::class, 'inputFormType'])
                                ->name("input_form_type");
                    Route::group(['prefix'=>'infos/{info}', 'as'=>'infos.'], function () {
                        // Sub-Categories Info. Inactive
                        Route::post('/inactive', [SubCategoryInfoController::class, 'inactive'])
                                    ->name("inactive");
                    });
                });

                // Policy
                Route::resource('policies', PolicyController::class,
                    ['only' => ['index', 'create', 'store']]);
                Route::group(['prefix'=>'policies/{policy}', 'as'=>'policies.'], function () {
                    // Policy Inactive
                    Route::post('/inactive', [PolicyController::class, 'inactive'])
                                ->name("inactive");

                    Route::resource('rates', PolicyRateController::class);
                    Route::group(['prefix'=>'rates/{rate}', 'as'=>'rates.'], function () {
                        // Policy Rate Inactive
                        Route::post('/inactive', [PolicyRateController::class, 'inactive'])
                                    ->name("inactive");
                    });

                });

            });
        });
        // Route::post('categories/{category}/remove', 'CategoriesController@remove')->name("categories.remove");

        Route::resource('ca-categories', CACategoriesController::class)->only([
            'index', 'create', 'store', 'edit', 'update'
        ]);
        Route::post('ca-categories/{ca_category}/remove', [CACategoriesController::class, 'remove'])->name("ca-categories.remove");

        Route::group(['prefix'=>'ca-categories/{ca_category}'], function () {
            // Sub-Categories
            Route::get('ca_sub_categories/input_sub_account_code/', [CASubCategoryController::class, 'inputSubAccountCode'])->name("input_sub_account_code");
            Route::resource('ca-sub-categories', CASubCategoryController::class);
            Route::group(['prefix'=>'ca-sub-categories/{ca_sub_category}'], function () {

                // Sub-Categories Info.
                Route::group(['as'=>'ca-sub-categories.'], function () {
                    Route::resource('infos', CASubCategoryInfoController::class);
                    Route::get('/input_form_type/{input_form_type}', [CASubCategoryInfoController::class, 'inputFormType'])
                                ->name("input_form_type");
                    Route::group(['prefix'=>'infos/{info}', 'as'=>'infos.'], function () {
                        // Sub-Categories Info. Inactive
                        Route::post('/inactive', [CASubCategoryInfoController::class, 'inactive'])
                                    ->name("inactive");
                    });
                });
            });
        });
        // Route::post('ca-categories/{category}/remove', 'CategoriesController@remove')->name("ca-categories.remove");

        Route::get('preferences', [PreferenceController::class, 'index'])->name('preferences.index');
        Route::post('preferences/update', [PreferenceController::class, 'update'])->name('preferences.update');
        Route::post('preferences/update_purpose', [PreferenceController::class, 'updatePurpose'])->name('preferences.update_purpose');
        Route::post('preferences/update_mapping_ous', [PreferenceController::class, 'updateMappingOU'])->name('preferences.update_mapping_ous');
        Route::post('preferences/slice_json', [PreferenceController::class, 'sliceJson'])->name('preferences.slice_json');

        Route::get('user-accounts/form_create', [UserAccountController::class, 'formCreate'])->name('user-accounts.form_create');
        Route::resource('user-accounts', UserAccountController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::get('user-accounts/{account_id}/form_edit', [UserAccountController::class, 'formEdit'])->name('user-accounts.form_edit');
        Route::post('user-accounts/{account_id}/set_default', [UserAccountController::class, 'setDefault'])->name('user-accounts.set_default');
        Route::post('user-accounts/sync', [UserAccountController::class, 'sync'])->name('user-accounts.sync');

        Route::resource('hierarchy', HierarchyController::class)->only([
            'index'
        ]);

        Route::get('hierarchy-topic/{topic_id}/form_edit', [HierarchyTopicController::class, 'formEdit'])->name('hierarchy-topic.form_edit');
        Route::resource('hierarchy-topic', HierarchyTopicController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);

        Route::get('hierarchy-type/{type_id}/form_edit', [HierarchyTypeController::class, 'formEdit'])->name('hierarchy-type.form_edit');
        Route::resource('hierarchy-type', HierarchyTypeController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);

        Route::resource('hierarchy-position', HierarchyPositionController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::group(['prefix'=>'hierarchy-position/{position_id}'], function () {

            Route::get('/form_edit', [HierarchyPositionController::class, 'formEdit'])->name('hierarchy-position.form_edit');

            Route::group(['as'=>'hierarchy-position.'], function () {
                Route::get('user/form_create', [HierarchyPositionUserController::class, 'formCreate'])->name('user.form_create');
                Route::post('user/{user}/set_default', [HierarchyPositionUserController::class, 'setDefault'])->name('user.set_default');
                Route::resource('user', HierarchyPositionUserController::class)->only([
                    'store', 'destroy'
                ]);
            });
        });

        Route::resource('hierarchy-name', HierarchyNameController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        Route::group(['prefix'=>'hierarchy-name/{name_id}'], function () {

            Route::get('/form_edit', [HierarchyNameController::class, 'formEdit'])->name('hierarchy-name.form_edit');

            Route::group(['as'=>'hierarchy-name.'], function () {
                Route::get('position/{name_position_id}/form_edit', [HierarchyNamePositionController::class, 'formEdit'])->name('position.form_edit');
                Route::resource('position', HierarchyNamePositionController::class)->only([
                    'index', 'store', 'update', 'destroy'
                ]);
            });
        });

        Route::resource('hierarchy-setup', HierarchySetupController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

    });

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('ct-invoice/getCtInvoiceDocument', [ReportController::class, 'getCtInvoiceDocument'])->name('ct-invoice.get-document');
        Route::get('ct-invoice/getCtInvoiceRequester', [ReportController::class, 'getCtInvoiceRequester'])->name('ct-invoice.get-user');
        Route::get('ct-invoice', [ReportController::class, 'ctInvoice'])->name('ct-invoice');
        Route::get('ct-wht/getCtWhtDocument', [ReportController::class, 'getCtWhtDocument'])->name('ct-wht.get-document');
        Route::get('ct-wht', [ReportController::class, 'ctWHT'])->name('ct-wht');
        Route::get('ct-ca', [ReportController::class, 'ctCa'])->name('ct-ca');
        Route::get('ct-budget/getCtBudgetDocument', [ReportController::class, 'getCtBudgetDocument'])->name('ct-budget.get-document');
        Route::get('ct-budget', [ReportController::class, 'ctBudget'])->name('ct-budget');
        Route::get('ct-vat/getCtVatDocument', [ReportController::class, 'getCtVatDocument'])->name('ct-vat.get-document');
        Route::get('ct-vat/getCtVatRequester', [ReportController::class, 'getCtVatRequester'])->name('ct-vat.get-user');
        Route::get('ct-vat', [ReportController::class, 'ctVat'])->name('ct-vat');
        Route::get('{type}/request/{parent}', [ReportController::class, 'request'])->name('request');
    });




        // Route::resource('locations', 'LocationController',['only'=>['index', 'create', 'store', 'edit', 'update']]);
        // Route::post('locations/inactive', 'LocationController@inactive')
        //                             ->name("locations.inactive");
