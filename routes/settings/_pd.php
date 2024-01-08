<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Route\settings;

use App\Http\Controllers\PD\Settings\SimuRawMaterialController;

use App\Http\Controllers\PD\Settings\Ajax\OhhandTobaccoForewarnController as AjaxOhhandTobaccoForewarnController;
use App\Http\Controllers\PD\Settings\OhhandTobaccoForewarnController;

use App\Http\Controllers\PD\HistoryInsteadGradesController;
use App\Http\Controllers\PD\Ajax\HistoryInsteadGradesController as AjaxHistoryInsteadGradesController;

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    //สายงานผู้ชำนาญการปรุง
    Route::get('ohhand-tobacco-forewarn/get-tobacco-itemcat-seg-1', [AjaxOhhandTobaccoForewarnController::class, 'getTobaccoItemcatSeg1']);
    Route::get('ohhand-tobacco-forewarn/get-tobacco-itemcat-seg-2', [AjaxOhhandTobaccoForewarnController::class, 'getTobaccoItemcatSeg2']);
    Route::get('ohhand-tobacco-forewarn/get-item-number', [AjaxOhhandTobaccoForewarnController::class, 'getItemNumber']);
    Route::get('ohhand-tobacco-forewarn/get-search-item-number', [AjaxOhhandTobaccoForewarnController::class, 'getSearchItemNumber']);
    Route::get('ohhand-tobacco-forewarn/search', [AjaxOhhandTobaccoForewarnController::class, 'search']);
    Route::post('ohhand-tobacco-forewarn/updateOrCreate', [AjaxOhhandTobaccoForewarnController::class, 'updateOrCreate']);

    Route::get('history-instead-grades/get-medicinal-leaf-types-l', [AjaxHistoryInsteadGradesController::class, 'getMedicinalLeafTypesL'])->name('history-instead-grades.getMedicinalLeafTypesL');
    Route::get('history-instead-grades/get-medicinal-leaf-item-v', [AjaxHistoryInsteadGradesController::class, 'getMedicinalLeafItemV'])->name('history-instead-grades.getMedicinalLeafItemV');
    Route::get('history-instead-grades/search', [AjaxHistoryInsteadGradesController::class, 'search'])->name('history-instead-grades.search');
    Route::get('history-instead-grades/get-Lot', [AjaxHistoryInsteadGradesController::class, 'getLot'])->name('history-instead-grades.getLot');
    Route::post('history-instead-grades/store', [AjaxHistoryInsteadGradesController::class, 'store'])->name('history-instead-grades.store');
    Route::get('history-instead-grades/destroy', [AjaxHistoryInsteadGradesController::class, 'destroy'])->name('history-instead-grades.destroy');
    Route::get('history-instead-grades/get-medicinal-leaf-item-l', [AjaxHistoryInsteadGradesController::class, 'getMedicinalLeafItemL'])->name('history-instead-grades.getMedicinalLeafItemL');
});

Route::group(['namespace' => 'Settings', 'prefix' => 'settings', 'as' => 'settings.'], function () {

    //กำหนดวัตถุดิบจำลอง
    Route::get('simu-raw-material', [SimuRawMaterialController::class, 'index'])->name('simu-raw-material.index');
    Route::get('simu-raw-material/create', [SimuRawMaterialController::class, 'create'])->name('simu-raw-material.create');
    Route::post('simu-raw-material', [SimuRawMaterialController::class, 'store'])->name('simu-raw-material.store');
    Route::get('simu-raw-material/{simu_raw_id}/edit', [SimuRawMaterialController::class, 'edit'])->name('simu-raw-material.edit');
    Route::put('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'update'])->name('simu-raw-material.update');
    Route::delete('simu-raw-material/{simu_raw_id}', [SimuRawMaterialController::class, 'destroy'])->name('simu-raw-material.delete');
    Route::get('simu-raw-material/{simu_raw_id}/create-inv', [SimuRawMaterialController::class, 'createInv'])->name('simu-raw-material.createInv');

    //สายงานผู้ชำนาญการปรุง
    Route::get('ohhand-tobacco-forewarn', [OhhandTobaccoForewarnController::class, 'index'])->name('ohhand-tobacco-forewarn.index');
    Route::post('ohhand-tobacco-forewarn/store/update/{forewarn_id}/{inventory_item_id}', [OhhandTobaccoForewarnController::class, 'update'])->name('ohhand-tobacco-forewarn.update');
});

    //บันทึกประวัติแทนเกรดใบยา
    Route::get('history-instead-grades', [HistoryInsteadGradesController::class, 'index'])->name('history-instead-grades.index');
