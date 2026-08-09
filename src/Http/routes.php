<?php

use Illuminate\Support\Facades\Route;
use ReportKit\Laravel\Http\Controllers\ReportDataController;
use ReportKit\Laravel\Http\Controllers\ReportWeeksController;

/**
 * Opt-in ReportKit routes (Laravel 5.5+).
 * Loaded only when routes.enabled is true via ReportKit::routes().
 */
$prefix = config('reportkit.routes.prefix', 'reportkit');
$middleware = config('reportkit.routes.middleware', []);

Route::group(['prefix' => $prefix, 'middleware' => $middleware], function () {
    Route::get('{slug}/data', [ReportDataController::class, 'data'])->name('reportkit.data');
    Route::get('{slug}/weeks', [ReportWeeksController::class, 'weeks'])->name('reportkit.weeks');
    Route::get('{slug}/rows', [ReportWeeksController::class, 'rows'])->name('reportkit.rows');
    Route::get('{slug}/trace', [ReportWeeksController::class, 'trace'])->name('reportkit.trace');
});
