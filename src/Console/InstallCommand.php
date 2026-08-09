<?php

namespace ReportKit\Laravel\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'reportkit:install';

    protected $description = 'Print ReportKit install checklist for Laravel 5.5+';

    public function handle()
    {
        $this->info('ReportKit install checklist (Laravel 5.5 → current)');
        $this->line('');
        $this->line('1. composer require reportkit/core reportkit/laravel');
        $this->line('2. Provider auto-discovered (or register ReportKit\\Laravel\\ReportKitServiceProvider)');
        $this->line('3. Create app/Reports/ for Report::define files');
        $this->line('4. Copy @reportkit/ui assets:');
        $this->line('   - public/css/reportkit/reportkit.css');
        $this->line('   - public/css/reportkit/reportkit-compat.css');
        $this->line('   - public/js/reportkit/reportkit.js');
        $this->line('5. Scaffold: php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --layout=layouts.app');
        $this->line('6. composer dump-autoload');
        $this->line('7. Register the printed Route::get lines');
        $this->line('8. Do NOT migrate existing host reports until ready');
        $this->line('');
        $this->info('Docs: https://github.com/Maijied/Reportkit-Laravel');

        return 0;
    }
}
