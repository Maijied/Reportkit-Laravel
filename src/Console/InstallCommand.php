<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * InstallCommand — One-time install helper — metadata from package composer.json (extra.reportkit).
 */

namespace ReportKit\Laravel\Legacy\Console;

use Illuminate\Console\Command;
use ReportKit\Core\Support\HostRuntime;
use ReportKit\Core\Support\PackageManifest;
use Symfony\Component\Console\Input\InputOption;

/**
 * One-time install helper — metadata from package composer.json (extra.reportkit).
 */
class InstallCommand extends Command
{
    /** @var PackageManifest|null */
    protected $manifestCache;

    protected $name = 'reportkit:install';

    public function getDescription()
    {
        return $this->manifest()->installCommandDescription();
    }

    public function fire()
    {
        $manifest = $this->manifest();
        $hostVersion = HostRuntime::laravelVersion(isset($this->laravel) ? $this->laravel : null);

        $this->info($manifest->installBanner($hostVersion));
        $this->line('');

        if ($this->option('with-config')) {
            $this->publishConfig();
        }

        if ($this->option('publish-assets')) {
            $this->copyUiAssets();
        }

        $step = 1;
        $this->line($step++ . '. ' . $manifest->formatComposerRequire());
        $this->line($step++ . '. Add provider: ' . $manifest->installMeta('provider'));
        $this->line(
            $step++ . '. Add alias: '
            . $manifest->installMeta('facade_alias')
            . ' => '
            . $manifest->installMeta('facade_class')
        );
        $this->line($step++ . '. php artisan reportkit:install --with-config --publish-assets');
        $this->line(
            $step++ . '. Create '
            . $manifest->installMeta('definitions_path', 'app/Reports/')
            . ' for Report::define files'
        );
        $this->line($step++ . '. Scaffold NEW reports only:');
        $this->line('   ' . $manifest->installMeta('scaffold_example'));
        $busNote = $manifest->installMeta('scaffold_bus_note');
        if ($busNote) {
            $this->line('   ' . $busNote);
        }
        if ($manifest->installMeta('needs_classmap_dump')) {
            $classmapNote = $manifest->installMeta('classmap_note', 'legacy');
            $this->line(
                $step++ . '. composer dump-autoload  (required for '
                . $classmapNote
                . ' classmap under app/controllers/admin/Reports/)'
            );
        }
        $this->line($step++ . '. Add the suggested Route::get lines to your domain route file');
        $this->line($step++ . '. Do NOT migrate existing reports until you are ready');
        $this->line('');
        $this->info('Docs: ' . $manifest->docsUrl('install'));
    }

    /**
     * Laravel 5.1+ prefers handle(); keep fire() for L4.
     *
     * @return int
     */
    public function handle()
    {
        $this->fire();

        return 0;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('publish-assets', null, InputOption::VALUE_NONE, 'Copy @lorapok-labs/reportkit-ui CSS/JS into public/css|js/reportkit/'),
            array('with-config', null, InputOption::VALUE_NONE, 'Publish config/reportkit.php into the host app'),
            array('force', 'f', InputOption::VALUE_NONE, 'Overwrite existing published config'),
        );
    }

    /**
     * @return PackageManifest
     */
    protected function manifest()
    {
        if (!$this->manifestCache) {
            $this->manifestCache = PackageManifest::fromPackageRoot($this->packageRoot());
        }

        return $this->manifestCache;
    }

    /**
     * @return string
     */
    protected function packageRoot()
    {
        return dirname(dirname(__DIR__));
    }

    /**
     * @param string $relative
     * @return string
     */
    protected function hostBase($relative)
    {
        if (function_exists('base_path')) {
            return base_path($relative);
        }

        return $this->laravel['path.base'] . '/' . ltrim($relative, '/');
    }

    /**
     * @return void
     */
    protected function publishConfig()
    {
        $src = $this->packageRoot() . '/config/reportkit.php';

        if (!is_file($src)) {
            $this->warn('Package config/reportkit.php missing.');
            return;
        }

        $destCandidates = array(
            $this->hostBase('config/reportkit.php'),
            $this->hostBase('app/config/reportkit.php'),
        );

        $dest = $destCandidates[0];

        foreach ($destCandidates as $candidate) {
            $dir = dirname($candidate);
            if (is_dir($dir)) {
                $dest = $candidate;
                break;
            }
        }

        $dir = dirname($dest);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (is_file($dest) && !$this->option('force')) {
            $this->line('Config already exists at ' . $dest . ' (use --force to overwrite)');
            return;
        }

        copy($src, $dest);
        $this->line('Published config → ' . $dest);
    }

    /**
     * @return void
     */
    protected function copyUiAssets()
    {
        $public = function_exists('public_path')
            ? public_path()
            : $this->laravel['path.public'];

        $targets = array(
            'css/reportkit.css' => $public . '/css/reportkit/reportkit.css',
            'css/reportkit-compat.css' => $public . '/css/reportkit/reportkit-compat.css',
            'js/lldp-core.js' => $public . '/js/reportkit/lldp-core.js',
            'js/lldp-download.js' => $public . '/js/reportkit/lldp-download.js',
            'js/reportkit.js' => $public . '/js/reportkit/reportkit.js',
        );

        $packageParent = dirname($this->packageRoot());
        $candidates = array(
            $this->hostBase('../reportkit-ui'),
            $this->hostBase('../../reportkit/reportkit-ui'),
            $packageParent . '/reportkit-ui',
            dirname($packageParent) . '/reportkit-ui',
        );

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
            $this->line('Published ' . $rel . ' → ' . $dest);
        }

        $animDir = $public . '/img/reportkit';
        $packageAnim = $this->packageRoot() . '/assets/animated';

        if (is_dir($packageAnim)) {
            if (!is_dir($animDir)) {
                mkdir($animDir, 0755, true);
            }

            foreach (glob($packageAnim . '/*.gif') as $gif) {
                $dest = $animDir . '/' . basename($gif);
                copy($gif, $dest);
                $this->line('Published animated/' . basename($gif) . ' → ' . $dest);
            }
        }
    }
}
