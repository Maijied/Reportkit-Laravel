> Plain-text overview for Packagist (no Mermaid). GitHub renders the full diagram version in [README.md](README.md).

<p align="center">
  <img src="https://raw.githubusercontent.com/Maijied/Reportkit-Core/main/brand/png/reportkit-mark-1024.png" alt="ReportKit for Laravel" width="160">
</p>

<h1 align="center">ReportKit for Laravel</h1>

<p align="center"><strong>Multi-database reports for Laravel 5.5 → 13 — install, scaffold, ship.</strong></p>

<p align="center">
  <a href="https://packagist.org/packages/reportkit/laravel"><img alt="Packagist Version" src="https://img.shields.io/packagist/v/reportkit/laravel?include_prereleases&label=packagist&color=0b7a4b"></a>
  <a href="https://packagist.org/packages/reportkit/laravel"><img alt="Downloads" src="https://img.shields.io/packagist/dt/reportkit/laravel?color=0b7a4b"></a>
  <img alt="PHP" src="https://img.shields.io/badge/php-%E2%89%A5%207.0-777bb4">
  <img alt="Laravel" src="https://img.shields.io/badge/laravel-5.5%20%E2%86%92%2013-ff2d20">
  <a href="https://packagist.org/packages/reportkit/laravel"><img alt="License" src="https://img.shields.io/packagist/l/reportkit/laravel?color=0b7a4b"></a>
</p>

> Modern Laravel adapter for [ReportKit Core](https://github.com/Maijied/Reportkit-Core) — auto-discovered provider, `ReportKit` facade, CAS Blade views, and Artisan scaffolding.
>
> **Website & docs:** https://reportkit.lorapok.tech · **Part of the Lorapok Labs ecosystem.**
>
> For Laravel **4.1–5.4**, use [`reportkit/laravel-legacy`](https://github.com/Maijied/Reportkit-Laravel-Legacy).

> A diagram-rich version of this README (with Mermaid) is shown on the [GitHub repository page](https://github.com/Maijied/Reportkit-Laravel).

## What you get

- **Auto-discovered** service provider + `ReportKit` facade.
- `php artisan reportkit:install` — one-command setup, optional `--with-config --publish-assets`.
- `php artisan reportkit:make` — full-stack report stubs (controller, views, tests, JS).
- View namespace `reportkit::` (publishable) and opt-in `ReportKit::routes()`.
- Never rewrites your existing reports.

```bash
php artisan reportkit:install --with-config --publish-assets
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --layout=layouts.app
```

## Requirements

- PHP **≥ 7.0**
- `illuminate/support` `>=5.5 <14`
- `reportkit/core` (beta channel allowed)
- Laravel **5.5 → current (12 / 13)**

## Install

```bash
composer require reportkit/core reportkit/laravel
```

Beta channel:

```bash
composer require "reportkit/laravel:^0.1@beta"
```

Install from Git (VCS):

```json
{
  "repositories": [
    { "type": "vcs", "url": "https://github.com/Maijied/Reportkit-Core.git" },
    { "type": "vcs", "url": "https://github.com/Maijied/Reportkit-Laravel.git" }
  ],
  "require": {
    "reportkit/core": "dev-main",
    "reportkit/laravel": "dev-main"
  }
}
```

Provider and facade are auto-discovered on Laravel 5.5+. Then:

```bash
php artisan reportkit:install --with-config --publish-assets
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --layout=layouts.app
composer dump-autoload
```

Create `app/Reports/` — the provider auto-requires `*.php` on boot. Register the printed routes (`{{route}}/data` for DataTables). Domain SQL stays in `app/Repositories/Reports`. Full checklist: [docs/INSTALL.md](docs/INSTALL.md).

## Merge multiple databases

```php
use ReportKit\Core\Source\MergedRowSource;
use ReportKit\Laravel\Source\ConnectionRowSource;

$domain = function ($query, array $filters) {
    return $query->from('orders')
        ->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
};

$live    = new ConnectionRowSource('mysql', $domain, null, 'live');
$archive = new ConnectionRowSource('mysql_archive', $domain, null, 'archive');

$source = (new MergedRowSource([$live, $archive]))
    ->dedupeBy('id')                 // first source wins (live over archive)
    ->orderBy('created_at', 'desc');

$rows = $source->getRows($filters);  // merged + deduped + sorted
```

## Ecosystem

| Package | Role |
|---------|------|
| `reportkit/core` | Engine (PHP 5.6 → 8.5) |
| `reportkit/laravel-legacy` | Laravel 4.1 – 5.4 |
| `reportkit/laravel` | This repository (5.5 → 12 / 13) |
| `@lorapok-labs/reportkit-ui` | Browser CSS/JS |

## Author

**Mohammad Maizied Hasan Majumder** (Maijied) · Senior Software Engineer @ Shohoz Ltd · Founder and Principal Engineer @ Lorapok Labs  
Dhaka, Bangladesh · [mdshuvo40@gmail.com](mailto:mdshuvo40@gmail.com) · [GitHub @Maijied](https://github.com/Maijied)

## License

MIT © Mohammad Maizied Hasan Majumder / Lorapok Labs
