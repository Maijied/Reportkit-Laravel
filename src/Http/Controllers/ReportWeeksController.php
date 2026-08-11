<?php

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Contracts\RowSource;
use ReportKit\Core\Filter\FilterValidator;
use ReportKit\Core\Report\ReportRegistry;

/**
 * Opt-in weeks endpoint for async_prepare reports.
 */
class ReportWeeksController
{
    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function weeks(Request $request, $slug)
    {
        $service = $this->resolveRowSource($slug);

        if ($service instanceof \Illuminate\Http\JsonResponse) {
            return $service;
        }

        $inputs = $request->all();
        $maxMonths = (int) config('reportkit.date.max_months', 6);
        $error = (new FilterValidator())->validateDateAndOptionalWeek($inputs, $maxMonths);

        if ($error) {
            return response()->json(['error' => $error], 422);
        }

        $weeks = $service->getWeeks($inputs);

        return response()->json(['weeks' => is_array($weeks) ? $weeks : []]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function rows(Request $request, $slug)
    {
        $service = $this->resolveRowSource($slug);

        if ($service instanceof \Illuminate\Http\JsonResponse) {
            return $service;
        }

        $inputs = $request->all();
        $maxMonths = (int) config('reportkit.date.max_months', 6);
        $error = (new FilterValidator())->validateDateAndOptionalWeek($inputs, $maxMonths);

        if ($error) {
            return response()->json(['error' => $error], 422);
        }

        $rows = $service->getRows($inputs);

        return response()->json([
            'rows' => is_array($rows) ? array_values($rows) : [],
            'count' => is_array($rows) ? count($rows) : 0,
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function trace(Request $request, $slug)
    {
        if (!config('reportkit.routes.trace', false)) {
            return response()->json(['error' => 'Trace disabled.'], 404);
        }

        $service = $this->resolveRowSource($slug);

        if ($service instanceof \Illuminate\Http\JsonResponse) {
            return $service;
        }

        $inputs = $request->all();
        $rows = $service->getRows($inputs);
        $trace = method_exists($service, 'getTrace') ? $service->getTrace() : [];

        return response()->json([
            'count' => is_array($rows) ? count($rows) : 0,
            'trace' => $trace,
        ]);
    }

    /**
     * @param string $slug
     * @return RowSource|\Illuminate\Http\JsonResponse
     */
    protected function resolveRowSource($slug)
    {
        $definition = ReportRegistry::get($slug);

        if (!$definition || empty($definition->serviceClass)) {
            return response()->json(['error' => 'Unknown report.'], 404);
        }

        $serviceClass = $definition->serviceClass;

        if (!class_exists($serviceClass)) {
            return response()->json(['error' => 'Report service missing.'], 500);
        }

        try {
            $service = app($serviceClass);
        } catch (\Exception $e) {
            $service = new $serviceClass();
        } catch (\Throwable $e) {
            $service = new $serviceClass();
        }

        if (!$service instanceof RowSource && !method_exists($service, 'getRows')) {
            return response()->json(['error' => 'Report service invalid.'], 500);
        }

        return $service;
    }
}
