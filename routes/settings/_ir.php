<?php

use Illuminate\Support\Facades\routes\settings;

use App\Http\Controllers\IR\Settings\GroupProductsController;
use App\Http\Controllers\IR\Settings\Ajax\GroupProductsController as AjaxGroupProductsController;

use App\Http\Controllers\IR\Settings\ProductInvHeaderController;
use App\Http\Controllers\IR\Settings\Ajax\ProductGroupController as AjaxProductGroupController;
use App\Http\Controllers\IR\Settings\SubGroupsController; 
use App\Http\Controllers\IR\Settings\Ajax\SubGroupsController as AjaxGroupsController; 
use App\Http\Controllers\IR\Settings\Ajax\AccountMappingController as AjaxAccountsMappingController;

use App\Http\Controllers\IR\Settings\EmailController;
use App\Http\Controllers\IR\Settings\Ajax\EmailController as AjaxEmailController;
use App\Http\Controllers\IR\Settings\Ajax\InventoryNotInsuranceContrller as AjaxInventoryNotInsuranceContrller;
use App\Http\Controllers\IR\Settings\Ajax\RoundingAssetController as AjaxRoundingAssetController;

use App\Http\Controllers\IR\Settings\InventoryNotInsuranceContrller;
use App\Http\Controllers\IR\Settings\RoundingAssetController;

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {

   Route::get('sub-groups/show/{policy_set_header_id}', [AjaxGroupsController::class, 'show'])->name('sub-groups.show');    
   Route::get('product-groups/updateActiveFlag', [AjaxGroupProductsController::class, 'updateActiveFlag'])->name('product-groups.updateActiveFlag');
   Route::get('sub-groups/check-inactive', [AjaxGroupsController::class, 'checkInactive'])->name('sub-groups.checkInactive');  

   Route::get('product-group', [AjaxProductGroupController::class, 'index'])->name('product-group');
   Route::get('get-locator', [AjaxProductGroupController::class, 'getLocator'])->name('get-locator');
   Route::get('product-header/updateActiveFlag', [AjaxProductGroupController::class, 'updateActiveFlag'])->name('updateActiveFlag');
   Route::get('destroy', [AjaxProductGroupController::class, 'destroy'])->name('destroy');
   Route::get('get-value-set', [AjaxProductGroupController::class, 'getValueSet'])->name('getValueSet');
   Route::get('product-header/getDataActiveFlag', [AjaxProductGroupController::class, 'getDataActiveFlag']);

   Route::get('sub-groups/show/{policy_set_header_id}', [AjaxGroupsController::class, 'show'])->name('sub-groups.show');  
   Route::get('sub-groups/check-inactive', [AjaxGroupsController::class, 'checkInactive'])->name('sub-groups.checkInactive');
   Route::get('sub-groups/destroy', [AjaxGroupsController::class, 'destroy'])->name('sub-groups.destroy');  

   Route::get('validate-account-mapping', [AjaxAccountsMappingController::class, 'validateAccountsMapping'])->name('validate-account-mapping');
   Route::get('account-mapping-update-flag', [AjaxAccountsMappingController::class, 'updateActiveFlag'])->name('account-mapping-update-flag');
    
   //IRM0010
   Route::get('email-update-flag', [AjaxEmailController::class, 'updateActiveFlag'])->name('email-update-flag');
   Route::get('email-check-duplicate', [AjaxEmailController::class, 'checkDuplicate'])->name('email-check-duplicate');
   Route::get('email-get-employee', [AjaxEmailController::class, 'getEmployee'])->name('email-get-employee');
   Route::get('email-get-department', [AjaxEmailController::class, 'getDepartment'])->name('email-get-department');

   // IRM0011
   Route::get('inventory-not-insurance/fetch', [AjaxInventoryNotInsuranceContrller::class, 'fetch'])->name('inventory-not-insurance.fetch');

   // IRM0012
   Route::get('rounding-asset/get-policy', [AjaxRoundingAssetController::class, 'getPolicy'])->name('rounding-asset.get-policy');
   Route::get('rounding-asset/get-asset', [AjaxRoundingAssetController::class, 'getAsset'])->name('rounding-asset.get-asset');
});

Route::prefix('settings')->name('settings.')->group(function () {

   Route::get('product-groups', [GroupProductsController::class, 'index'])->name('product-groups.index');
   Route::get('product-groups/create', [GroupProductsController::class, 'create'])->name('product-groups.create');
   Route::post('product-groups/store', [GroupProductsController::class, 'store'])->name('product-groups.store');
   Route::post('product-groups/update', [GroupProductsController::class, 'update'])->name('product-groups.update');
   Route::get('product-groups/{id}/edit', [GroupProductsController::class, 'edit'])->name('product-groups.edit');

   Route::get('product-header', [ProductInvHeaderController::class, 'index'])->name('product-header.index');
   Route::get('product-header/create', [ProductInvHeaderController::class, 'create'])->name('product-header.create');
   Route::post('product-header/store', [ProductInvHeaderController::class, 'store'])->name('product-header.store');
   Route::get('product-header/search', [ProductInvHeaderController::class, 'search'])->name('product-header.search');
   Route::get('product-header/{id}/edit', [ProductInvHeaderController::class, 'edit'])->name('product-header.edit');
   Route::put('product-header/update', [ProductInvHeaderController::class, 'update'])->name('product-header.update');

   Route::get('sub-groups', [SubGroupsController::class, 'index'])->name('sub-groups.index');
   Route::get('sub-groups/create', [SubGroupsController::class, 'create'])->name('sub-groups.create');
   Route::post('sub-groups/update', [SubGroupsController::class, 'update'])->name('sub-groups.update');
   Route::post('sub-groups/store', [SubGroupsController::class, 'store'])->name('sub-groups.store');
   Route::get('sub-groups/search', [SubGroupsController::class, 'search'])->name('sub-groups.search');
   Route::get('sub-groups/{id}/edit', [SubGroupsController::class, 'edit'])->name('sub-groups.edit');
   
   //IRM0010
   Route::resource('email', EmailController::class);
   // Route::get('email', [EmailController::class, 'index'])->name('email.index');
   // Route::get('email/create', [EmailController::class, 'create'])->name('email.create');
   // Route::post('email', [EmailController::class, 'store'])->name('email.store');
   // Route::get('email/{id}/edit', [EmailController::class, 'edit'])->name('email.edit');
   // // Route::post('email/update', [EmailController::class, 'update'])->name('email.update');
   // Route::put('email/update', [EmailController::class, 'update'])->name('email.update');
   Route::get('email/search', [EmailController::class, 'search'])->name('email.search');

   //IRM0011
   Route::resource('inventory-not-insurance', InventoryNotInsuranceContrller::class);
   Route::get('inventory-not-insurance/export', [RoundingAssetController::class, 'export'])->name('inventory-not-insurance.export');

   //IRM0012
   Route::resource('rounding-asset', RoundingAssetController::class);
   Route::get('rounding-asset/export', [RoundingAssetController::class, 'export'])->name('rounding-asset.export');
});