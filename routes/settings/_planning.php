<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Route\settings;

use App\Http\Controllers\Planning\Settings\YearlyProdLineController;

Route::prefix('settings')->name('settings.')->group(function () {
    //PMS0045
    Route::get('yearly-prod-line', [YearlyProdLineController::class, 'index'])->name('yearly-prod-line.index');
    Route::post('yearly-prod-line', [YearlyProdLineController::class, 'store'])->name('yearly-prod-line.store');
});