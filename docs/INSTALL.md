# Install ReportKit on Laravel 5.5+

## 1. Composer

```bash
composer require reportkit/core reportkit/laravel
```

Or VCS repositories:

- https://github.com/Maijied/Reportkit-Core.git
- https://github.com/Maijied/Reportkit-Laravel.git

Provider / alias are **auto-discovered** on Laravel 5.5+ (`extra.laravel` in composer.json). Manual registration is only needed on older discovery-less hosts.

## 2. UI assets

From https://github.com/Maijied/Reportkit-UI :

```bash
mkdir -p public/css/reportkit public/js/reportkit
# copy css/reportkit.css
# copy css/reportkit-compat.css
# copy js/reportkit.js
```

Optional: `php artisan vendor:publish --tag=reportkit-views` to customize Blade partials.

## 3. Checklist

```bash
php artisan reportkit:install
```

## 4. Scaffold a NEW report only

```bash
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --dry-run
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --layout=layouts.app
composer dump-autoload
```

`--layout` defaults to `layouts.app`. Register the printed routes (`{{route}}/data` for DataTables). Domain SQL stays in `app/Repositories/Reports`.

**Do not rewrite existing host reports until you explicitly migrate them.**

## 5. Definitions folder

Create `app/Reports/` — the provider auto-requires `*.php` on boot.

## 6. Optional routes helper

Set `routes.enabled` to `true` on the settings store, then call `ReportKit::routes()` to load `src/Http/routes.php` (`reportkit/{slug}/data`). Default remains **disabled**.
