<?php

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Report\ReportRegistry;
use ReportKit\Core\Table\DataTableResponder;
use ReportKit\Core\Table\PseudoPaginator;

/**
 * Opt-in generic DataTables endpoint for a registered report slug.
 * Loaded only when reportkit.settings routes.enabled is true.
 */
class ReportDataController
{
    /**
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request, $slug)
    {
        $definition = ReportRegistry::get($slug);

        if (!$definition || empty($definition->serviceClass)) {
            return response()->json(['error' => 'Unknown report.'], 404);
        }

        $serviceClass = $definition->serviceClass;

        if (!class_exists($serviceClass)) {
            return response()->json(['error' => 'Report service missing.'], 500);
        }

        $inputs = $request->all();
        $service = new $serviceClass();
        $rows = method_exists($service, 'getRows') ? $service->getRows($inputs) : [];
        $summary = method_exists($service, 'getSummary') ? $service->getSummary($rows) : [];

        $paginator = new PseudoPaginator();
        $start = isset($inputs['start']) ? (int) $inputs['start'] : 0;
        $length = isset($inputs['length']) ? (int) $inputs['length'] : 25;
        $page = $paginator->slice($rows, $start, $length);

        $responder = new DataTableResponder();

        return response()->json(
            $responder->respond($inputs, $page, count($rows), count($rows), $summary)
        );
    }
}
