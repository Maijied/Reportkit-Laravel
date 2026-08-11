<?php

namespace ReportKit\Laravel\Console;

use Illuminate\Console\Command;

/**
 * Scaffold a new report stack for modern Laravel hosts.
 * Does NOT modify existing reports.
 */
class MakeReportCommand extends Command
{
    protected $signature = 'reportkit:make
        {name : Studly report name, e.g. Demo}
        {--route= : Route prefix}
        {--preset=hybrid : datatable|prepare|hybrid}
        {--layout=layouts.app : Blade layout to @extends (unused when stub extends reportkit layout)}
        {--flags= : Comma list overriding preset}
        {--force : Overwrite existing files}
        {--dry-run : Print paths only}';

    protected $description = 'Scaffold a new ReportKit report (stubs only; does not change existing reports)';

    public function handle()
    {
        $name = $this->argument('name');
        $studly = preg_replace('/[^A-Za-z0-9]/', '', $name);
        $slug = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $studly));
        $route = $this->option('route') ?: ('admin/' . $slug . '-report');
        $preset = $this->option('preset') ?: 'hybrid';
        $layout = $this->option('layout') ?: 'layouts.app';
        $flags = $this->resolveFlags($preset, $this->option('flags'));
        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        $this->info("Scaffold ReportKit report: {$studly} (preset={$preset}, route={$route})");
        $this->line('Flags: ' . implode(',', array_keys(array_filter($flags))));
        $this->line('Layout: ' . $layout);
        $this->line('');

        $stubDir = dirname(dirname(__DIR__)) . '/resources/stubs';
        $replacements = [
            '{{Studly}}' => $studly,
            '{{slug}}' => $slug,
            '{{route}}' => $route,
            '{{title}}' => preg_replace('/([a-z])([A-Z])/', '$1 $2', $studly) . ' Report',
            '{{preset}}' => $preset,
            '{{layout}}' => $layout,
            '{{flags_php}}' => $this->exportFlagsPhp($flags),
        ];

        $map = [
            "app/Reports/{$studly}Report.php" => 'report.definition.stub',
            "app/Repositories/Reports/{$studly}ReportRepository.php" => 'report.repository.stub',
            "app/Services/Reports/{$studly}ReportService.php" => 'report.service.stub',
            "app/Http/Controllers/Reports/{$studly}ReportController.php" => 'report.controller.stub',
            "resources/views/reports/{$slug}.blade.php" => 'report.blade.stub',
            "public/js/reports/{$slug}.js" => 'report.js.stub',
            "tests/Feature/Reports/{$studly}ReportTest.php" => 'report.test.stub',
        ];

        foreach ($map as $relative => $stubName) {
            if ($dryRun) {
                $this->line('[dry-run] ' . $relative);
                continue;
            }

            $target = base_path($relative);
            $stubFile = $stubDir . '/' . $stubName;

            if (file_exists($target) && !$force) {
                $this->comment("Skip existing: {$relative}");
                continue;
            }

            if (!file_exists($stubFile)) {
                $this->error("Missing stub: {$stubName}");
                continue;
            }

            $dir = dirname($target);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            file_put_contents($target, strtr(file_get_contents($stubFile), $replacements));
            $this->info("Wrote {$relative}");
        }

        if ($dryRun) {
            $this->info('Dry run only — no files written.');
            return 0;
        }

        $this->line('');
        $this->info('Next: fill repository SQL, register routes, composer dump-autoload, run tests.');
        $this->comment('Suggested routes:');
        $this->line("  Route::get('{$route}', [\\App\\Http\\Controllers\\Reports\\{$studly}ReportController::class, 'index']);");
        if (!empty($flags['datatables'])) {
            $this->line("  Route::get('{$route}/data', [\\App\\Http\\Controllers\\Reports\\{$studly}ReportController::class, 'data']);");
        }
        $this->comment('Existing reports were not modified.');

        return 0;
    }

    /**
     * @param string $preset
     * @param string|null $flagsOpt
     * @return array
     */
    protected function resolveFlags($preset, $flagsOpt)
    {
        $defaults = [
            'datatable' => [
                'datatables' => true, 'sync' => true, 'async_prepare' => false,
                'kpi' => true, 'excel' => true, 'csv' => true, 'pdf' => false, 'email' => false,
            ],
            'prepare' => [
                'datatables' => false, 'sync' => false, 'async_prepare' => true,
                'kpi' => true, 'excel' => true, 'csv' => true, 'pdf' => true, 'email' => true,
            ],
            'hybrid' => [
                'datatables' => true, 'sync' => true, 'async_prepare' => true,
                'kpi' => true, 'excel' => true, 'csv' => true, 'pdf' => true, 'email' => false,
            ],
        ];

        $flags = isset($defaults[$preset]) ? $defaults[$preset] : $defaults['hybrid'];

        if ($flagsOpt) {
            $requested = array_filter(array_map('trim', explode(',', $flagsOpt)));
            $all = ['datatables', 'sync', 'async_prepare', 'kpi', 'excel', 'csv', 'pdf', 'email', 'print', 'howto'];
            foreach ($all as $key) {
                $flags[$key] = in_array($key, $requested, true);
            }
        }

        return $flags;
    }

    /**
     * @param array $flags
     * @return string
     */
    protected function exportFlagsPhp(array $flags)
    {
        $lines = [];
        foreach ($flags as $key => $on) {
            $lines[] = "            '{$key}' => " . ($on ? 'true' : 'false') . ',';
        }

        return implode("\n", $lines);
    }
}
