<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ReportKit — @method static \ReportKit\Core\Report\ReportDefinition define(string $id, callable $callback = null).
 */

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
