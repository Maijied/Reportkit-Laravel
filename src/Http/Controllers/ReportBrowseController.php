<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ReportBrowseController — Post-prepare JSON browse — session-backed prepared rows (Phase K).
 */

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Http\HandlesReportBrowse;
use ReportKit\Core\Report\ReportRegistry;
use ReportKit\Core\Settings\ReportSettingsResolver;
use ReportKit\Core\Settings\ReportkitConfig;

/**
 * Post-prepare JSON browse — session-backed prepared rows (Phase K).
 */
class ReportBrowseController
{
    use HandlesReportBrowse;
    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePrepared(Request $request, $slug)
    {
        $definition = ReportRegistry::get($slug);

        if (!$definition) {
            return response()->json(['error' => 'Unknown report.'], 404);
        }

        $rows = $request->input('rows', []);

        if (!is_array($rows) || !$rows) {
            return response()->json(['error' => 'No prepared rows supplied.'], 422);
        }

        $encoded = json_encode($rows);

        if ($encoded === false) {
            return response()->json(['error' => 'Could not serialize rows.'], 422);
        }

        $config = ReportkitConfig::load(app(), dirname(dirname(__DIR__)) . '/config/reportkit.php');
        $maxBytes = (int) ReportSettingsResolver::get($slug, $config, 'store.session_persist_max_bytes', 1500000);

        if (strlen($encoded) > $maxBytes) {
            return response()->json(['error' => 'Prepared payload over session limit.'], 422);
        }

        $request->session()->put($this->preparedSessionKey($slug), $rows);

        return response()->json([
            'ok' => true,
            'count' => count($rows),
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function browse(Request $request, $slug)
    {
        $definition = ReportRegistry::get($slug);

        if (!$definition) {
            return response()->json(['error' => 'Unknown report.'], 404);
        }

        $rows = $request->session()->get($this->preparedSessionKey($slug), []);

        if (!is_array($rows) || !$rows) {
            return response()->json(['error' => 'No prepared data. Run prepare first.'], 422);
        }

        $config = ReportkitConfig::load(app(), dirname(dirname(__DIR__)) . '/config/reportkit.php');
        $pageLimitMax = (int) ReportSettingsResolver::get($slug, $config, 'table.page_limit_max', 10000);
        $payload = $this->browsePreparedRows($request->all(), $rows, $definition, $pageLimitMax);

        return response()->json($payload);
    }
}
