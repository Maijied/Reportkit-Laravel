<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * routes.php — package HTTP routes.
 */

use Illuminate\Support\Facades\Route;
use ReportKit\Laravel\Http\Controllers\ReportBrowseController;
use ReportKit\Laravel\Http\Controllers\ReportDataController;
use ReportKit\Laravel\Http\Controllers\ReportSendController;
use ReportKit\Laravel\Http\Controllers\ReportWeeksController;
use ReportKit\Laravel\Http\Controllers\SettingsController;

/**
 * Opt-in ReportKit routes (Laravel 5.5+).
 * Loaded only when routes.enabled is true via ReportKit::routes().
 */
$prefix = config('reportkit.routes.prefix', 'reportkit');
$middleware = config('reportkit.routes.middleware', []);

Route::group(['prefix' => $prefix, 'middleware' => $middleware], function () {
    Route::get('settings.json', [SettingsController::class, 'json'])->name('reportkit.settings');
    Route::get('{slug}/settings.json', [SettingsController::class, 'forReport'])->name('reportkit.report.settings');
    Route::get('{slug}/data', [ReportDataController::class, 'data'])->name('reportkit.data');
    Route::get('{slug}/weeks', [ReportWeeksController::class, 'weeks'])->name('reportkit.weeks');
    Route::get('{slug}/rows', [ReportWeeksController::class, 'rows'])->name('reportkit.rows');
    Route::get('{slug}/trace', [ReportWeeksController::class, 'trace'])->name('reportkit.trace');
    Route::post('{slug}/prepared', [ReportBrowseController::class, 'storePrepared'])->name('reportkit.prepared.store');
    Route::get('{slug}/browse', [ReportBrowseController::class, 'browse'])->name('reportkit.browse');
    Route::post('{slug}/send', [ReportSendController::class, 'send'])->name('reportkit.send');
});
