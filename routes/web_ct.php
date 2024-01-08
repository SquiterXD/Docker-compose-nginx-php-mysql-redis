<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CT\FileController;
use App\Http\Controllers\CT\AllocateRatioController;
use App\Http\Controllers\CT\StdCostController;
use App\Http\Controllers\CT\StdCostPaperController;
use App\Http\Controllers\CT\StdCostInquiryController;
use App\Http\Controllers\CT\OemCostController;
use App\Http\Controllers\CT\WorkorderProcessController;
use App\Http\Controllers\CT\Reports\CTR0019Controller;
use App\Http\Controllers\CT\Reports\CTR0020Controller;
use App\Http\Controllers\CT\Reports\CTR0021Controller;
use App\Http\Controllers\CT\Reports\CTR0022Controller;
use App\Http\Controllers\CT\Reports\CTR0023Controller;
use App\Http\Controllers\CT\Reports\CTR0024Controller;
use App\Http\Controllers\CT\Reports\CTR0026Controller;
use App\Http\Controllers\CT\Reports\CTR0029Controller;
use App\Http\Controllers\CT\Reports\CTR0030Controller;

// FILE
Route::get('/files/image/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'image'])->name('files.image');
Route::get('/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}', [FileController::class, 'imageThumbnail'])->name('files.image-thumbnail');
Route::get('/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}', [FileController::class, 'download'])->name('files.download');

// # ALLOCATE_RATIOS
Route::get('/allocate-ratios/download-template', [AllocateRatioController::class, 'downloadTemplate'])->name('allocate-ratios.download-template');
Route::get('/allocate-ratios', [AllocateRatioController::class, 'index'])->name('allocate-ratios.index');

// STD_COST
Route::get('/std-costs', [StdCostController::class, 'index'])->name('std-costs.index');
// Route::post('/std-costs/export', [StdCostController::class, 'export'])->name('std-costs.export');

// STD_COST_PAPERS
Route::get('/std-cost-papers', [StdCostPaperController::class, 'index'])->name('std-cost-papers.index');
Route::get('/std-cost-papers/materials', [StdCostPaperController::class, 'materials'])->name('std-cost-papers.materials');
Route::get('/std-cost-papers/account-targets', [StdCostPaperController::class, 'accountTargets'])->name('std-cost-papers.account-targets');
Route::get('/std-cost-papers/summarizes', [StdCostPaperController::class, 'summarizes'])->name('std-cost-papers.summarizes');

// STD_COST INQUIRY
Route::get('/std-cost-inquiries', [StdCostInquiryController::class, 'index'])->name('std-cost-inquiries.index');

// OEM_COST
Route::get('/oem-costs', [OemCostController::class, 'index'])->name('oem-costs.index');

// # WORKORDER_PROCESSES
Route::get('/workorders/processes', [WorkorderProcessController::class, 'index'])->name('workorders.processes.index');


// ## REPORTS

// # CTR0019
Route::get('/ctr0019', [CTR0019Controller::class, 'index'])->name('ctr0019.index');
Route::post('/ctr0019/export', [CTR0019Controller::class, 'export'])->name('ctr0019.export');

// # CTR0020
Route::get('/ctr0020', [CTR0020Controller::class, 'index'])->name('ctr0020.index');
Route::post('/ctr0020/export', [CTR0020Controller::class, 'export'])->name('ctr0020.export');

// # CTR0021
Route::get('/ctr0021', [CTR0021Controller::class, 'index'])->name('ctr0021.index');
Route::post('/ctr0021/export', [CTR0021Controller::class, 'export'])->name('ctr0021.export');

// # CTR0022
Route::get('/ctr0022', [CTR0022Controller::class, 'index'])->name('ctr0022.index');
Route::post('/ctr0022/export', [CTR0022Controller::class, 'export'])->name('ctr0022.export');

// # CTR0023
Route::get('/ctr0023', [CTR0023Controller::class, 'index'])->name('ctr0023.index');
Route::post('/ctr0023/export', [CTR0023Controller::class, 'export'])->name('ctr0023.export');

// # CTR0024
Route::get('/ctr0024', [CTR0024Controller::class, 'index'])->name('ctr0024.index');
Route::post('/ctr0024/export', [CTR0024Controller::class, 'export'])->name('ctr0024.export');

// # CTR0026
Route::get('/ctr0026', [CTR0026Controller::class, 'index'])->name('ctr0026.index');
Route::post('/ctr0026/export', [CTR0026Controller::class, 'export'])->name('ctr0026.export');

// # CTR0029
Route::get('/ctr0029', [CTR0029Controller::class, 'index'])->name('ctr0029.index');
Route::post('/ctr0029/export', [CTR0029Controller::class, 'export'])->name('ctr0029.export');

// # CTR0030
Route::get('/ctr0030', [CTR0030Controller::class, 'index'])->name('ctr0030.index');
Route::post('/ctr0030/export', [CTR0030Controller::class, 'export'])->name('ctr0030.export');