# Install ReportKit on Laravel 5.5+

## Composer

```bash
composer require reportkit/core reportkit/laravel
```

Provider / alias are auto-discovered on Laravel 5.5+.

## UI assets

Copy from https://github.com/Maijied/Reportkit-UI into `public/css/reportkit/` and `public/js/reportkit/`.

## Checklist

```bash
php artisan reportkit:install
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --dry-run
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid
```

Register the printed routes. Domain SQL stays in `app/Repositories/Reports`.

**Do not rewrite existing host reports until you explicitly migrate them.**
