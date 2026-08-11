<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * InstallCommand — @return PackageManifest.
 */

namespace ReportKit\Laravel\Console;

use Illuminate\Console\Command;
use ReportKit\Core\Support\HostRuntime;
use ReportKit\Core\Support\PackageManifest;

class InstallCommand extends Command
{
    /** @var PackageManifest|null */
    protected $manifestCache;

    protected $signature = 'reportkit:install
                            {--publish-assets : Publish @lorapok-labs/reportkit-ui CSS/JS into public/vendor/reportkit}
                            {--with-config : Publish config/reportkit.php}';

    public function getDescription()
    {
        return $this->manifest()->installCommandDescription();
    }

    public function handle()
    {
        $manifest = $this->manifest();
        $hostVersion = HostRuntime::laravelVersion($this->laravel);

        $this->info($manifest->installBanner($hostVersion));
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

        $step = 1;
        $this->line($step++ . '. ' . $manifest->formatComposerRequire());
        $this->line($step++ . '. php artisan reportkit:install --with-config --publish-assets');
        $this->line(
            $step++ . '. Create '
            . $manifest->installMeta('definitions_path', 'app/Reports/')
            . ' for Report::define files'
        );
        $this->line($step++ . '. Scaffold: ' . $manifest->installMeta('scaffold_example'));
        $optional = $manifest->installMeta('optional_note');
        if ($optional) {
            $this->line($step++ . '. ' . $optional);
        }
        $this->line($step++ . '. Do NOT migrate existing host reports until ready');
        $this->line('');
        $this->info('Docs: ' . $manifest->docsUrl('install'));

        return 0;
    }

    /**
     * @return PackageManifest
     */
    protected function manifest()
    {
        if (!$this->manifestCache) {
            $this->manifestCache = PackageManifest::fromPackageRoot(dirname(__DIR__, 2));
        }

        return $this->manifestCache;
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

        $this->copyAnimatedAssets();
    }

    /**
     * Copy Kit-Larva loader GIFs into public/vendor/reportkit/img/.
     *
     * @return void
     */
    protected function copyAnimatedAssets()
    {
        $packageRoot = dirname(__DIR__, 2);
        $packageAnim = $packageRoot . '/assets/animated';
        $destDir = public_path('vendor/reportkit/img');

        if (!is_dir($packageAnim)) {
            return;
        }

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        foreach (glob($packageAnim . '/*.gif') as $gif) {
            $dest = $destDir . '/' . basename($gif);
            copy($gif, $dest);
            $this->line('Published animated/' . basename($gif));
        }
    }
}
