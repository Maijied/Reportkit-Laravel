<?php

use Illuminate\Support\Facades\Route;
use ReportKit\Laravel\Http\Controllers\ReportDataController;

/**
 * Opt-in ReportKit routes (Laravel 5.5+).
 * Loaded only when routes.enabled is true via ReportKit::routes().
 */
Route::get('reportkit/{slug}/data', [ReportDataController::class, 'data'])
    ->name('reportkit.data');
