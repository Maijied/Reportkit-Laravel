<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ReportWeeksController — Opt-in weeks endpoint for async_prepare reports.
 */

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Http\AjaxResponse;
use ReportKit\Core\Http\HandlesReportWeeks;

/**
 * Opt-in weeks endpoint for async_prepare reports.
 */
class ReportWeeksController
{
    use HandlesReportWeeks;

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeks(Request $request, $slug)
    {
        return $this->respond($this->reportWeeksPayload($slug, $request->all(), config('reportkit', [])));
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function rows(Request $request, $slug)
    {
        return $this->respond($this->reportRowsPayload($slug, $request->all(), config('reportkit', [])));
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function trace(Request $request, $slug)
    {
        $enabled = (bool) config('reportkit.routes.trace', false);

        return $this->respond($this->reportTracePayload($slug, $request->all(), config('reportkit', []), $enabled));
    }

    /**
     * @param array $payload
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond(array $payload)
    {
        $status = AjaxResponse::status($payload);
        unset($payload['_status']);

        return response()->json($payload, $status);
    }

    /**
     * @param string $serviceClass
     * @return object
     */
    protected function makeReportService($serviceClass)
    {
        try {
            return app($serviceClass);
        } catch (\Exception $e) {
            return new $serviceClass();
        } catch (\Throwable $e) {
            return new $serviceClass();
        }
    }
}
