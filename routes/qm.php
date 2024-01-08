<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QM\Api\FinishedProductController as ApiFinishedProductController;
use App\Http\Controllers\QM\Api\QtmMachineController as ApiQtmMachineController;
use App\Http\Controllers\QM\Api\TobaccoController as ApiTobaccoController;
use App\Http\Controllers\QM\Api\MothOutbreakController as ApiMothOutbreakController;
use App\Http\Controllers\QM\Api\PacketAirLeakController as ApiPacketAirLeakController;

use App\Http\Controllers\QM\FinishedProductController;
use App\Http\Controllers\QM\QtmMachineController;
use App\Http\Controllers\QM\TobaccoController;
use App\Http\Controllers\QM\MothOutbreakController;
use App\Http\Controllers\QM\PacketAirLeakController;
use App\Http\Controllers\QM\FileController;

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

require base_path('routes/settings/_qm.php');

Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {

    Route::get('/tobaccos/get-batch-items', [ApiTobaccoController::class, 'getBatchItems'])->name('tobaccos.get-batch-items');
    Route::get('/tobaccos/get-sample-specifications', [ApiTobaccoController::class, 'getSampleSpecifications'])->name('tobaccos.get-sample-specifications');
    Route::get('/tobaccos/get-mes-batch-items', [ApiTobaccoController::class, 'getMesBatchItems'])->name('tobaccos.get-mes-batch-items');
    Route::post('/tobaccos/result', [ApiTobaccoController::class, 'storeSampleResult'])->name('tobaccos.store-sample-result');
    Route::post('/tobaccos/approval/approve', [ApiTobaccoController::class, 'approvalApprove'])->name('tobaccos.approval.approve');
    Route::post('/tobaccos/approval/approve-all', [ApiTobaccoController::class, 'approvalApproveAll'])->name('tobaccos.approval.approve-all');
    Route::post('/tobaccos/approval/reject', [ApiTobaccoController::class, 'approvalReject'])->name('tobaccos.approval.reject');
    Route::post('/tobaccos/approval/return', [ApiTobaccoController::class, 'approvalReturn'])->name('tobaccos.approval.return');
    Route::post('/tobaccos/approval/unapprove', [ApiTobaccoController::class, 'approvalUnapprove'])->name('tobaccos.approval.unapprove');

    Route::get('/finished-products/get-sample-specifications', [ApiFinishedProductController::class, 'getSampleSpecifications'])->name('finished-products.get-sample-specifications');
    Route::post('/finished-products/result', [ApiFinishedProductController::class, 'storeSampleResult'])->name('finished-products.store-sample-result');
    Route::post('/finished-products/defect', [ApiFinishedProductController::class, 'storeDefect'])->name('finished-products.store-sample-defect');
    Route::post('/finished-products/remark', [ApiFinishedProductController::class, 'storeRemark'])->name('finished-products.store-sample-remark');
    Route::post('/finished-products/delete-result-quality-line-image', [ApiFinishedProductController::class, 'deleteResultQualityLineImage'])->name('finished-products.delete-result-quality-line-image');
    Route::post('/finished-products/approval/approve', [ApiFinishedProductController::class, 'approvalApprove'])->name('finished-products.approval.approve');
    Route::post('/finished-products/approval/approve-all', [ApiFinishedProductController::class, 'approvalApproveAll'])->name('finished-products.approval.approve-all');
    Route::post('/finished-products/approval/reject', [ApiFinishedProductController::class, 'approvalReject'])->name('finished-products.approval.reject');
    Route::post('/finished-products/approval/return', [ApiFinishedProductController::class, 'approvalReturn'])->name('finished-products.approval.return');
    Route::post('/finished-products/approval/unapprove', [ApiFinishedProductController::class, 'approvalUnapprove'])->name('finished-products.approval.unapprove');
    Route::post('/finished-products/export-pdf/report-chart-summary', [ApiFinishedProductController::class, 'exportPdfReportChartSummary'])->name('finished-products.export-pdf.report-chart-summary');

    Route::get('/qtm-machines/get-sample-specifications', [ApiQtmMachineController::class, 'getSampleSpecifications'])->name('qtm-machines.get-sample-specifications');
    Route::post('/qtm-machines/result', [ApiQtmMachineController::class, 'storeSampleResult'])->name('qtm-machines.store-sample-result');
    Route::post('/qtm-machines/confirm', [ApiQtmMachineController::class, 'confirm'])->name('qtm-machines.confirm');
    Route::post('/qtm-machines/reject', [ApiQtmMachineController::class, 'reject'])->name('qtm-machines.reject');
    Route::post('/qtm-machines/defect', [ApiQtmMachineController::class, 'storeDefect'])->name('qtm-machines.store-sample-defect');
    Route::post('/qtm-machines/update-time-drawn', [ApiQtmMachineController::class, 'updateTimeDrawn'])->name('qtm-machines.update-time-drawn');
    Route::post('/qtm-machines/approval/approve', [ApiQtmMachineController::class, 'approvalApprove'])->name('qtm-machines.approval.approve');
    Route::post('/qtm-machines/approval/approve-all', [ApiQtmMachineController::class, 'approvalApproveAll'])->name('qtm-machines.approval.approve-all');
    Route::post('/qtm-machines/approval/reject', [ApiQtmMachineController::class, 'approvalReject'])->name('qtm-machines.approval.reject');
    Route::post('/qtm-machines/approval/return', [ApiQtmMachineController::class, 'approvalReturn'])->name('qtm-machines.approval.return');
    Route::post('/qtm-machines/approval/unapprove', [ApiQtmMachineController::class, 'approvalUnapprove'])->name('qtm-machines.approval.unapprove');
    Route::post('/qtm-machines/export-pdf/report-summary', [ApiQtmMachineController::class, 'exportPdfReportSummary'])->name('moth-outbreaks.export-pdf.report-summary');

    Route::get('/packet-air-leaks/get-sample-specifications', [ApiPacketAirLeakController::class, 'getSampleSpecifications'])->name('packet-air-leaks.get-sample-specifications');
    Route::post('/packet-air-leaks/result', [ApiPacketAirLeakController::class, 'storeSampleResult'])->name('packet-air-leaks.store-sample-result');
    Route::post('/packet-air-leaks/defect', [ApiPacketAirLeakController::class, 'storeDefect'])->name('packet-air-leaks.store-sample-defect');
    // Route::post('/packet-air-leaks/update-sample-test-time', [ApiPacketAirLeakController::class, 'updateSampleTestTime'])->name('packet-air-leaks.update-sample-test-time');
    Route::post('/packet-air-leaks/approval/approve', [ApiPacketAirLeakController::class, 'approvalApprove'])->name('packet-air-leaks.approval.approve');
    Route::post('/packet-air-leaks/approval/approve-all', [ApiPacketAirLeakController::class, 'approvalApproveAll'])->name('packet-air-leaks.approval.approve-all');
    Route::post('/packet-air-leaks/approval/reject', [ApiPacketAirLeakController::class, 'approvalReject'])->name('packet-air-leaks.approval.reject');
    Route::post('/packet-air-leaks/approval/return', [ApiPacketAirLeakController::class, 'approvalReturn'])->name('packet-air-leaks.approval.return');
    Route::post('/packet-air-leaks/approval/unapprove', [ApiPacketAirLeakController::class, 'approvalUnapprove'])->name('packet-air-leaks.approval.unapprove');
    Route::post('/packet-air-leaks/export-pdf/report-daily-leak-average', [ApiPacketAirLeakController::class, 'exportPdfReportDailyLeakAverage'])->name('packet-air-leaks.export-pdf.report-daily-leak-average');

    Route::get('/moth-outbreaks/get-sample-specifications', [ApiMothOutbreakController::class, 'getSampleSpecifications'])->name('moth-outbreaks.get-sample-specifications');
    Route::post('/moth-outbreaks/upload-excel-file', [ApiMothOutbreakController::class, 'uploadExcelFile'])->name('moth-outbreaks.upload-excel-file');
    Route::post('/moth-outbreaks/result', [ApiMothOutbreakController::class, 'storeSampleResult'])->name('moth-outbreaks.store-sample-result');
    Route::post('/moth-outbreaks/samples', [ApiMothOutbreakController::class, 'storeSamples'])->name('moth-outbreaks.store-samples');
    Route::post('/moth-outbreaks/results', [ApiMothOutbreakController::class, 'storeSampleResults'])->name('moth-outbreaks.store-sample-results');
    Route::post('/moth-outbreaks/call-pkg-add-results', [ApiMothOutbreakController::class, 'callPackageAddSampleResults'])->name('moth-outbreaks.call-pkg-add-results');
    Route::post('/moth-outbreaks/set-sample-result-status', [ApiMothOutbreakController::class, 'setSampleResultStatus'])->name('moth-outbreaks.set-sample-result-status');
    Route::post('/moth-outbreaks/approval/approve', [ApiMothOutbreakController::class, 'approvalApprove'])->name('moth-outbreaks.approval.approve');
    Route::post('/moth-outbreaks/approval/approve-all', [ApiMothOutbreakController::class, 'approvalApproveAll'])->name('moth-outbreaks.approval.approve-all');
    Route::post('/moth-outbreaks/approval/reject', [ApiMothOutbreakController::class, 'approvalReject'])->name('moth-outbreaks.approval.reject');
    Route::post('/moth-outbreaks/approval/return', [ApiMothOutbreakController::class, 'approvalReturn'])->name('moth-outbreaks.approval.return');
    Route::post('/moth-outbreaks/approval/unapprove', [ApiMothOutbreakController::class, 'approvalUnapprove'])->name('moth-outbreaks.approval.unapprove');
    Route::post('/moth-outbreaks/report-locator-chart/save-image', [ApiMothOutbreakController::class, 'saveImageReportLocatorChart'])->name('moth-outbreaks.report-locator-chart.save-image');
    Route::post('/moth-outbreaks/export-pdf/report-locator-chart', [ApiMothOutbreakController::class, 'exportPdfReportLocatorChart'])->name('moth-outbreaks.export-pdf.report-locator-chart');
    
});


// TOAT-QMP001, TOAT-QMP002, TOAT-QMP003
// Route::get('/tobaccos', [TobaccoController::class, 'index'])->name('tobaccos.index');
Route::get('/tobaccos/create', [TobaccoController::class, 'create'])->name('tobaccos.create');
Route::get('/tobaccos/result', [TobaccoController::class, 'result'])->name('tobaccos.result');
Route::get('/tobaccos/track', [TobaccoController::class, 'track'])->name('tobaccos.track');
Route::get('/tobaccos/approval', [TobaccoController::class, 'approval'])->name('tobaccos.approval');
Route::get('/tobaccos/report-summary', [TobaccoController::class, 'reportSummary'])->name('tobaccos.report-summary');
Route::get('/tobaccos/report-process', [TobaccoController::class, 'reportProcess'])->name('tobaccos.report-process');
Route::get('/tobaccos/report-silo', [TobaccoController::class, 'reportSilo'])->name('tobaccos.report-silo');
Route::post('/tobaccos/export-excel/report-summary', [TobaccoController::class, 'exportExcelReportSummary'])->name('tobaccos.export-excel.report-summary');
Route::post('/tobaccos/export-excel/report-process', [TobaccoController::class, 'exportExcelReportProcess'])->name('tobaccos.export-excel.report-process');
Route::post('/tobaccos/export-pdf/report-process', [TobaccoController::class, 'exportPdfReportProcess'])->name('tobaccos.export-pdf.report-process');
Route::post('/tobaccos/export-excel/report-silo', [TobaccoController::class, 'exportExcelReportSilo'])->name('tobaccos.export-excel.report-silo');
Route::post('/tobaccos', [TobaccoController::class, 'store'])->name('tobaccos.store');

// TOAT-QMP004, TOAT-QMP005, TOAT-QMP006, TOAT-QMP007
// Route::get('/finished-products', [FinishedProductController::class, 'index'])->name('finished-products.index');
Route::get('/finished-products/create', [FinishedProductController::class, 'create'])->name('finished-products.create');
Route::get('/finished-products/result', [FinishedProductController::class, 'result'])->name('finished-products.result');
Route::get('/finished-products/track', [FinishedProductController::class, 'track'])->name('finished-products.track');
Route::get('/finished-products/defect', [FinishedProductController::class, 'defect'])->name('finished-products.defect');
Route::get('/finished-products/approval', [FinishedProductController::class, 'approval'])->name('finished-products.approval');
Route::get('/finished-products/report-chart-summary', [FinishedProductController::class, 'reportChartSummary'])->name('finished-products.report-chart-summary');
Route::get('/finished-products/report-issue', [FinishedProductController::class, 'reportIssue'])->name('finished-products.report-issue');
Route::get('/finished-products/report-issue-details', [FinishedProductController::class, 'reportIssueDetails'])->name('finished-products.report-issue-details');
Route::get('/finished-products/report-defect', [FinishedProductController::class, 'reportDefect'])->name('finished-products.report-defect');
Route::get('/finished-products/report-summary', [FinishedProductController::class, 'reportSummary'])->name('finished-products.report-summary');
Route::get('/finished-products/report-result-lines', [FinishedProductController::class, 'reportResultLines'])->name('finished-products.report-result-lines');
Route::get('/finished-products/report-physical-quality', [FinishedProductController::class, 'reportPhysicalQuality'])->name('finished-products.report-physical-quality');
Route::get('/finished-products/report-leak', [FinishedProductController::class, 'reportLeak'])->name('finished-products.report-leak');
// Route::post('/finished-products/export-excel/report-issue', [FinishedProductController::class, 'exportExcelReportIssue'])->name('finished-products.export-excel.report-issue');
Route::post('/finished-products/export-pdf/report-issue', [FinishedProductController::class, 'exportPdfReportIssue'])->name('finished-products.export-pdf.report-issue');
// Route::post('/finished-products/export-pdf/report-issue-details', [FinishedProductController::class, 'exportPdfReportIssueDetails'])->name('finished-products.export-pdf.report-issue-details');
Route::post('/finished-products/export-excel/report-defect', [FinishedProductController::class, 'exportExcelReportDefect'])->name('finished-products.export-excel.report-defect');
Route::post('/finished-products/export-pdf/report-summary', [FinishedProductController::class, 'exportPdfReportSummary'])->name('finished-products.export-pdf.report-summary');
// Route::post('/finished-products/export-excel/report-summary', [FinishedProductController::class, 'exportExcelReportSummary'])->name('finished-products.export-excel.report-summary');
Route::post('/finished-products/export-excel/report-result-lines', [FinishedProductController::class, 'exportExcelReportResultLines'])->name('finished-products.export-excel.report-result-lines');
Route::post('/finished-products/export-excel/report-physical-quality', [FinishedProductController::class, 'exportExcelReportPhysicalQuality'])->name('finished-products.export-excel.report-physical-quality');
Route::post('/finished-products/export-excel/report-leak', [FinishedProductController::class, 'exportExcelReportLeak'])->name('finished-products.export-excel.report-leak');
Route::post('/finished-products', [FinishedProductController::class, 'store'])->name('finished-products.store');
Route::post('/finished-products/result', [FinishedProductController::class, 'storeResult'])->name('finished-products.store-result');

// TOAT-QMP008, TOAT-QMP009, TOAT-QMP010, TOAT-QMP011, TOAT-QMP021, TOAT-QMP022, TOAT-QMP023
// Route::get('/qtm-machines', [QtmMachineController::class, 'index'])->name('qtm-machines.index');
Route::get('/qtm-machines/create', [QtmMachineController::class, 'create'])->name('qtm-machines.create');
Route::get('/qtm-machines/result', [QtmMachineController::class, 'result'])->name('qtm-machines.result');
Route::get('/qtm-machines/track', [QtmMachineController::class, 'track'])->name('qtm-machines.track');
Route::get('/qtm-machines/defect', [QtmMachineController::class, 'defect'])->name('qtm-machines.defect');
Route::get('/qtm-machines/approval', [QtmMachineController::class, 'approval'])->name('qtm-machines.approval');
Route::get('/qtm-machines/report-summary', [QtmMachineController::class, 'reportSummary'])->name('qtm-machines.report-summary');
Route::get('/qtm-machines/report-under-average', [QtmMachineController::class, 'reportUnderAverage'])->name('qtm-machines.report-under-average');
Route::get('/qtm-machines/report-under-average-summary', [QtmMachineController::class, 'reportUnderAverageSummary'])->name('qtm-machines.report-under-average-summary');
Route::get('/qtm-machines/report-product-quality', [QtmMachineController::class, 'reportProductQuality'])->name('qtm-machines.report-product-quality');
Route::get('/qtm-machines/report-quantum-neo', [QtmMachineController::class, 'reportQuantumNeo'])->name('qtm-machines.report-quantum-neo');
Route::get('/qtm-machines/report-physical-value', [QtmMachineController::class, 'reportPhysicalValue'])->name('qtm-machines.report-physical-value');
Route::post('/qtm-machines/export-excel/report-under-average', [QtmMachineController::class, 'exportExcelReportUnderAverage'])->name('qtm-machines.export-excel.report-under-average');
Route::post('/qtm-machines/export-excel/report-under-average-summary', [QtmMachineController::class, 'exportExcelReportUnderAverageSummary'])->name('qtm-machines.export-excel.report-under-average-summary');
Route::post('/qtm-machines/export-pdf/report-under-average-summary', [QtmMachineController::class, 'exportPdfReportUnderAverageSummary'])->name('qtm-machines.export-pdf.report-under-average-summary');
Route::post('/qtm-machines/export-excel/report-product-quality', [QtmMachineController::class, 'exportExcelReportProductQuality'])->name('qtm-machines.export-excel.report-product-quality');
Route::post('/qtm-machines/export-pdf/report-quantum-neo', [QtmMachineController::class, 'exportPdfReportQuantumNeo'])->name('qtm-machines.export-pdf.report-quantum-neo');
Route::post('/qtm-machines/export-excel/report-physical-value', [QtmMachineController::class, 'exportExcelReportPhysicalValue'])->name('qtm-machines.export-excel.report-physical-value');
Route::post('/qtm-machines/export-pdf/report-physical-value', [QtmMachineController::class, 'exportPdfReportPhysicalValue'])->name('qtm-machines.export-pdf.report-physical-value');
Route::post('/qtm-machines', [QtmMachineController::class, 'store'])->name('qtm-machines.store');
Route::post('/qtm-machines/result', [QtmMachineController::class, 'storeResult'])->name('qtm-machines.store-result');
Route::get('/qtm-machines/error-export-excel', [QtmMachineController::class, 'errorExportExcel'])->name('qtm-machines.error-export-excel');

// TOAT-QMP0012, TOAT-QMP0013, TOAT-QMP0014, TOAT-QMP0015, TOAT-QMP0024
// Route::get('/packet-air-leaks', [PacketAirLeakController::class, 'index'])->name('packet-air-leaks.index');
Route::get('/packet-air-leaks/create', [PacketAirLeakController::class, 'create'])->name('packet-air-leaks.create');
Route::get('/packet-air-leaks/result', [PacketAirLeakController::class, 'result'])->name('packet-air-leaks.result');
Route::get('/packet-air-leaks/track', [PacketAirLeakController::class, 'track'])->name('packet-air-leaks.track');
Route::get('/packet-air-leaks/defect', [PacketAirLeakController::class, 'defect'])->name('packet-air-leaks.defect');
Route::get('/packet-air-leaks/approval', [PacketAirLeakController::class, 'approval'])->name('packet-air-leaks.approval');
Route::get('/packet-air-leaks/report', [PacketAirLeakController::class, 'report'])->name('packet-air-leaks.report');
Route::get('/packet-air-leaks/report-summary', [PacketAirLeakController::class, 'reportSummary'])->name('packet-air-leaks.report-summary');
Route::get('/packet-air-leaks/report-leak-rate', [PacketAirLeakController::class, 'reportLeakRate'])->name('packet-air-leaks.report-leak-rate');
Route::get('/packet-air-leaks/report-daily-leak-average', [PacketAirLeakController::class, 'reportDailyLeakAverage'])->name('packet-air-leaks.report-daily-leak-average');
Route::post('/packet-air-leaks/export-excel/report', [PacketAirLeakController::class, 'exportExcelReport'])->name('packet-air-leaks.export-excel.report');
Route::post('/packet-air-leaks/export-pdf/report-summary', [PacketAirLeakController::class, 'exportPdfReportSummary'])->name('packet-air-leaks.export-pdf.report-summary');
Route::post('/packet-air-leaks/export-excel/report-leak-rate', [PacketAirLeakController::class, 'exportExcelReportLeakRate'])->name('packet-air-leaks.export-excel.report-leak-rate');
Route::post('/packet-air-leaks/export-pdf/report-leak-rate', [PacketAirLeakController::class, 'exportPdfReportLeakRate'])->name('packet-air-leaks.export-pdf.report-leak-rate');
Route::post('/packet-air-leaks', [PacketAirLeakController::class, 'store'])->name('packet-air-leaks.store');
Route::post('/packet-air-leaks/result', [PacketAirLeakController::class, 'storeResult'])->name('packet-air-leaks.store-result');

// TOAT-QMP0016, TOAT-QMP0017, TOAT-QMP018, TOAT-QMP019
// Route::get('/moth-outbreaks', [MothOutbreakController::class, 'index'])->name('moth-outbreaks.index');
Route::get('/moth-outbreaks/create', [MothOutbreakController::class, 'create'])->name('moth-outbreaks.create');
Route::get('/moth-outbreaks/result', [MothOutbreakController::class, 'result'])->name('moth-outbreaks.result');
Route::get('/moth-outbreaks/track', [MothOutbreakController::class, 'track'])->name('moth-outbreaks.track');
Route::get('/moth-outbreaks/approval', [MothOutbreakController::class, 'approval'])->name('moth-outbreaks.approval');
Route::get('/moth-outbreaks/report-summary', [MothOutbreakController::class, 'reportSummary'])->name('moth-outbreaks.report-summary');
Route::get('/moth-outbreaks/report-locator-summary', [MothOutbreakController::class, 'reportLocatorSummary'])->name('moth-outbreaks.report-locator-summary');
Route::get('/moth-outbreaks/report-locator-chart', [MothOutbreakController::class, 'reportLocatorChart'])->name('moth-outbreaks.report-locator-chart');
Route::post('/moth-outbreaks/export-excel/report-summary', [MothOutbreakController::class, 'exportExcelReportSummary'])->name('moth-outbreaks.export-excel.report-summary');
Route::post('/moth-outbreaks/export-excel/report-locator-summary', [MothOutbreakController::class, 'exportExcelReportLocatorSummary'])->name('moth-outbreaks.export-excel.report-locator-summary');
Route::post('/moth-outbreaks/export-pdf/report-locator-chart', [MothOutbreakController::class, 'exportPdfReportLocatorChart'])->name('moth-outbreaks.export-pdf.report-locator-chart');
Route::post('/moth-outbreaks', [MothOutbreakController::class, 'store'])->name('moth-outbreaks.store');
Route::post('/moth-outbreaks/result', [MothOutbreakController::class, 'storeResult'])->name('moth-outbreaks.store-result');

Route::get('/files/image/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'image'])->name('files.image');
Route::get('/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'imageThumbnail'])->name('files.image-thumbnail');
Route::get('/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}', [FileController::class, 'download'])->name('files.download');
