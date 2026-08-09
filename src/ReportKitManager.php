<?php

namespace ReportKit\Laravel;

use ReportKit\Core\Report\Report as CoreReport;
use ReportKit\Core\Report\ReportRegistry;

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
