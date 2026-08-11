<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ReportKitServiceProvider — Laravel 5.5+ service provider for ReportKit.
 */

namespace ReportKit\Laravel;

use Illuminate\Support\ServiceProvider;
use ReportKit\Core\Settings\ArraySettingsStore;
use ReportKit\Core\Settings\BrowserSettingsBuilder;
use ReportKit\Core\Settings\ConfigSettingsMapper;
use ReportKit\Core\Settings\ReportkitConfig;
use ReportKit\Core\Settings\SettingsStore;
use ReportKit\Laravel\Console\InstallCommand;
use ReportKit\Laravel\Console\MakeReportCommand;

/**
 * Laravel 5.5+ service provider for ReportKit.
 */
class ReportKitServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $configPath = dirname(__DIR__) . '/config/reportkit.php';

        if (method_exists($this, 'mergeConfigFrom') && is_file($configPath)) {
            $this->mergeConfigFrom($configPath, 'reportkit');
        }

        $this->app->singleton('reportkit.settings', function ($app) {
            $config = function_exists('config') ? config('reportkit', []) : [];

            return new ArraySettingsStore(ConfigSettingsMapper::fromReportkitConfig($config));
        });

        $packageRoot = dirname(__DIR__);
        $this->app->singleton('reportkit.browser_settings', function ($app) use ($packageRoot) {
            $config = ReportkitConfig::load($app, $packageRoot . '/config/reportkit.php');

            return BrowserSettingsBuilder::fromConfig($config);
        });

        $this->app->bind(SettingsStore::class, function ($app) {
            return $app['reportkit.settings'];
        });

        $this->app->singleton('reportkit', function () {
            return new ReportKitManager();
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $viewPath = dirname(__DIR__) . '/resources/views';
        $configPath = dirname(__DIR__) . '/config/reportkit.php';

        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, 'reportkit');
        }

        if (method_exists($this, 'publishes')) {
            $publishes = [];

            if (is_dir($viewPath)) {
                $publishes[$viewPath] = resource_path('views/vendor/reportkit');
            }

            $this->publishes($publishes, 'reportkit-views');

            if (is_file($configPath)) {
                $this->publishes([
                    $configPath => function_exists('config_path')
                        ? config_path('reportkit.php')
                        : base_path('config/reportkit.php'),
                ], 'reportkit-config');
            }

            $uiCss = dirname(__DIR__) . '/resources/assets/css';
            $uiJs = dirname(__DIR__) . '/resources/assets/js';

            if (is_dir($uiCss) || is_dir($uiJs)) {
                $assetMap = [];

                if (is_dir($uiCss)) {
                    $assetMap[$uiCss] = public_path('vendor/reportkit/css');
                }

                if (is_dir($uiJs)) {
                    $assetMap[$uiJs] = public_path('vendor/reportkit/js');
                }

                $this->publishes($assetMap, 'reportkit-assets');
            }
        }

        $this->loadReportDefinitions();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                MakeReportCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function loadReportDefinitions()
    {
        $relative = config('reportkit.definitions_path', 'app/Reports');
        $path = base_path($relative);

        if (!is_dir($path)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && substr($file->getFilename(), -4) === '.php') {
                require $file->getPathname();
            }
        }
    }

    /**
     * Opt-in route registration when routes.enabled is true.
     *
     * @return void
     */
    public static function registerRoutes()
    {
        $app = function_exists('app') ? app() : null;

        if (!$app) {
            return;
        }

        $enabled = false;

        if (function_exists('config')) {
            $enabled = (bool) config('reportkit.routes.enabled', false);
        }

        if (!$enabled && isset($app['reportkit.settings'])) {
            $enabled = (bool) $app['reportkit.settings']->get('routes.enabled', false);
        }

        if (!$enabled) {
            return;
        }

        $routesFile = __DIR__ . '/Http/routes.php';

        if (is_file($routesFile)) {
            require $routesFile;
        }
    }
}
