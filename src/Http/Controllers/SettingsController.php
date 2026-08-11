<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * SettingsController — Public browser settings JSON (ceilings, brand, logging flags only).
 */

namespace ReportKit\Laravel\Http\Controllers;

use ReportKit\Core\Report\ReportRegistry;
use ReportKit\Core\Settings\BrowserSettingsBuilder;
use ReportKit\Core\Settings\ReportkitConfig;

/**
 * Public browser settings JSON (ceilings, brand, logging flags only).
 */
class SettingsController
{
    /**
     * GET /reportkit/settings.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function json()
    {
        return $this->respond(null);
    }

    /**
     * GET /reportkit/{slug}/settings.json
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function forReport($slug)
    {
        return $this->respond($slug);
    }

    /**
     * @param string|null $slug
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($slug)
    {
        $config = ReportkitConfig::load(
            function_exists('app') ? app() : null,
            dirname(__DIR__, 2) . '/config/reportkit.php'
        );
        $definition = $slug ? ReportRegistry::get($slug) : null;

        if ($slug && !$definition) {
            return response()->json(['error' => 'Unknown report.'], 404);
        }

        return response()->json(BrowserSettingsBuilder::forReport($config, $definition));
    }
}
