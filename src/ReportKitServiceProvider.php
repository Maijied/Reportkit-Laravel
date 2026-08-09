<?php

namespace ReportKit\Laravel;

use Illuminate\Support\ServiceProvider;
use ReportKit\Core\Settings\ArraySettingsStore;
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
        $this->app->singleton('reportkit.settings', function () {
            return new ArraySettingsStore([
                'brand.name' => 'ReportKit',
                'brand.pdf_disclaimer' => 'This document was generated for authorized use only.',
                'brand.accent' => '#0b7a4b',
                'routes.enabled' => false,
            ]);
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

        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, 'reportkit');
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
        $path = base_path('app/Reports');

        if (!is_dir($path)) {
            return;
        }

        foreach (glob($path . '/*.php') as $file) {
            require $file;
        }
    }
}
