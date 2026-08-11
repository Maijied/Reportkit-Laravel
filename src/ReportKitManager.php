<?php

namespace ReportKit\Laravel;

use ReportKit\Core\Report\Report as CoreReport;
use ReportKit\Core\Report\ReportRegistry;
use ReportKit\Core\Source\MergedRowSource;
use ReportKit\Laravel\Source\ConnectionRowSource;

class ReportKitManager
{
    /**
     * @param string $id
     * @param callable|null $callback
     * @return \ReportKit\Core\Report\ReportDefinition
     */
    public function define($id, $callback = null)
    {
        return CoreReport::define($id, $callback);
    }

    /**
     * @param string $id
     * @return \ReportKit\Core\Report\ReportDefinition|null
     */
    public function get($id)
    {
        return CoreReport::get($id);
    }

    /**
     * @return array
     */
    public function all()
    {
        return CoreReport::all();
    }

    /**
     * Build a ConnectionRowSource for a named DB connection.
     *
     * @param string $connection
     * @param callable $callback
     * @param string|null $label
     * @return ConnectionRowSource
     */
    public function connection($connection, $callback, $label = null)
    {
        return new ConnectionRowSource($connection, $callback, null, $label);
    }

    /**
     * Merge multiple RowSources (typically ConnectionRowSource instances).
     *
     * @param array $sources
     * @param string|null $dedupeKey
     * @param string|null $orderBy
     * @param string $direction
     * @return MergedRowSource
     */
    public function merged(array $sources, $dedupeKey = null, $orderBy = null, $direction = 'asc')
    {
        return new MergedRowSource($sources, $dedupeKey, $orderBy, $direction);
    }

    /**
     * Opt-in route registration when routes.enabled is true.
     * Always returns registered report ids.
     *
     * @return array
     */
    public function routes()
    {
        ReportKitServiceProvider::registerRoutes();

        return array_keys(ReportRegistry::all());
    }
}
