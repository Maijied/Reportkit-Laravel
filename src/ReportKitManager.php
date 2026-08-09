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
     * Return registered report ids. Host may expand this into Route:: groups later.
     *
     * @return array
     */
    public function routes()
    {
        return array_keys(ReportRegistry::all());
    }
}
