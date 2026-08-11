<?php

namespace ReportKit\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use ReportKit\Core\Contracts\RowSource;
use ReportKit\Core\Filter\FilterValidator;
use ReportKit\Core\Report\ReportRegistry;
use ReportKit\Core\Table\DataTableResponder;
use ReportKit\Core\Table\PseudoPaginator;

/**
 * Opt-in generic DataTables endpoint for a registered report slug.
 * Loaded only when reportkit.routes.enabled is true.
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

        if (!empty($inputs['start_date']) || !empty($inputs['end_date'])) {
            $maxMonths = (int) config('reportkit.date.max_months', 6);
            $dateError = (new FilterValidator())->validateDateAndOptionalWeek($inputs, $maxMonths);

            if ($dateError) {
                return response()->json(['error' => $dateError], 422);
            }
        }

        $service = $this->resolveService($serviceClass);

        if (!$service instanceof RowSource && !method_exists($service, 'getRows')) {
            return response()->json(['error' => 'Report service invalid.'], 500);
        }

        $rows = $service->getRows($inputs);
        if (!is_array($rows)) {
            $rows = [];
        }

        $paginator = new PseudoPaginator();
        $search = isset($inputs['search']['value']) ? $inputs['search']['value'] : (isset($inputs['search']) && is_string($inputs['search']) ? $inputs['search'] : '');
        $columns = [];

        if (!empty($definition->tables[0]) && is_object($definition->tables[0]) && !empty($definition->tables[0]->columns)) {
            foreach ($definition->tables[0]->columns as $col) {
                if (is_object($col) && isset($col->key)) {
                    $columns[] = $col->key;
                } elseif (is_array($col) && isset($col['key'])) {
                    $columns[] = $col['key'];
                }
            }
        }

        if ($search !== '' && !empty($columns)) {
            $rows = $paginator->searchBy($rows, $search, $columns);
        }

        if (!empty($inputs['order'][0]['column']) || isset($inputs['order'][0]['column'])) {
            $colIndex = (int) $inputs['order'][0]['column'];
            $dir = isset($inputs['order'][0]['dir']) ? $inputs['order'][0]['dir'] : 'asc';
            if (isset($columns[$colIndex])) {
                $rows = $paginator->sortBy($rows, $columns[$colIndex], $dir);
            }
        }

        $filtered = count($rows);
        $start = isset($inputs['start']) ? (int) $inputs['start'] : 0;
        $length = isset($inputs['length'])
            ? (int) $inputs['length']
            : (int) config('reportkit.table.default_page_length', 25);
        $page = $paginator->slice($rows, $start, $length);
        $summary = method_exists($service, 'getSummary') ? $service->getSummary($rows) : [];

        $responder = new DataTableResponder();

        return response()->json(
            $responder->respond($inputs, $page, $filtered, $filtered, $summary)
        );
    }

    /**
     * @param string $serviceClass
     * @return object
     */
    protected function resolveService($serviceClass)
    {
        if (function_exists('app')) {
            try {
                return app($serviceClass);
            } catch (\Exception $e) {
                // fall through
            } catch (\Throwable $e) {
                // fall through
            }
        }

        return new $serviceClass();
    }
}
