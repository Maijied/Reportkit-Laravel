<?php

namespace ReportKit\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ReportKit\Core\Report\ReportDefinition define(string $id, callable $callback = null)
 * @method static \ReportKit\Core\Report\ReportDefinition|null get(string $id)
 * @method static array all()
 * @method static array routes()
 */
class ReportKit extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'reportkit';
    }
}
