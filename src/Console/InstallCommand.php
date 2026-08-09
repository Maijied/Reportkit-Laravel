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
        $this->line('4. Copy @reportkit/ui assets into public/vendor/reportkit/ (or public/css|js/reportkit/)');
        $this->line('5. php artisan reportkit:make Demo --route=admin/demo-report --dry-run');
        $this->line('6. Do NOT migrate existing host reports until ready');
        $this->line('');
        $this->info('Docs: https://github.com/Maijied/Reportkit-Laravel');

        return 0;
    }
}
