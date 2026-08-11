<?php

namespace ReportKit\Laravel\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'reportkit:install
                            {--publish-assets : Publish @lorapok-labs/reportkit-ui CSS/JS into public/vendor/reportkit}
                            {--with-config : Publish config/reportkit.php}';

    protected $description = 'Install ReportKit checklist / publish assets & config (Laravel 5.5+)';

    public function handle()
    {
        $this->info('ReportKit install (Laravel 5.5 → current)');
        $this->line('');

        if ($this->option('with-config') && method_exists($this, 'call')) {
            $this->call('vendor:publish', [
                '--tag' => 'reportkit-config',
                '--force' => true,
            ]);
        }

        if ($this->option('publish-assets') && method_exists($this, 'call')) {
            $this->call('vendor:publish', [
                '--tag' => 'reportkit-assets',
                '--force' => true,
            ]);
            $this->copyUiFromSiblingOrVendor();
        }

        $this->line('1. composer require reportkit/core reportkit/laravel');
        $this->line('2. php artisan reportkit:install --with-config --publish-assets');
        $this->line('3. Create app/Reports/ for Report::define files');
        $this->line('4. Scaffold: php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid');
        $this->line('5. Set reportkit.routes.enabled=true and call ReportKit::routes() (optional)');
        $this->line('6. Do NOT migrate existing host reports until ready');
        $this->line('');
        $this->info('Docs: https://reportkit.lorapok.tech/docs/0.1/getting-started/installation');

        return 0;
    }

    /**
     * Fallback: copy UI assets from sibling workspace package when publish tag is empty.
     *
     * @return void
     */
    protected function copyUiFromSiblingOrVendor()
    {
        $targets = [
            'css/reportkit.css' => public_path('vendor/reportkit/css/reportkit.css'),
            'css/reportkit-compat.css' => public_path('vendor/reportkit/css/reportkit-compat.css'),
            'js/reportkit.js' => public_path('vendor/reportkit/js/reportkit.js'),
        ];

        $candidates = [
            base_path('../reportkit-ui'),
            base_path('../../reportkit/reportkit-ui'),
            dirname(__DIR__, 3) . '/reportkit-ui',
        ];

        $root = null;

        foreach ($candidates as $candidate) {
            if (is_dir($candidate) && is_file($candidate . '/js/reportkit.js')) {
                $root = $candidate;
                break;
            }
        }

        if (!$root) {
            $this->warn('UI assets package not found locally — copy from https://github.com/Maijied/Reportkit-UI or npm @lorapok-labs/reportkit-ui');
            return;
        }

        foreach ($targets as $rel => $dest) {
            $src = $root . '/' . $rel;

            if (!is_file($src)) {
                continue;
            }

            $dir = dirname($dest);

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            copy($src, $dest);
            $this->line('Published ' . $rel);
        }
    }
}
