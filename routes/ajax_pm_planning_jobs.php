<?php

use App\Http\Controllers\PM\Ajax\PlanningJobController;
use Illuminate\Support\Facades\Route;

Route::get('/planning-jobs', [PlanningJobController::class, 'index'])->name('planning-jobs.index');
Route::get('/planning-jobs/max-rev', [PlanningJobController::class, 'maxRev'])->name('planning-jobs.max-rev');
