# Install ReportKit on Laravel 5.5+

## 1. Composer

```bash
composer require reportkit/core reportkit/laravel
```

Or VCS monorepo (single clone):

- https://github.com/Maijied/Reportkit-Core.git

Provider / alias are **auto-discovered** on Laravel 5.5+ (`extra.laravel` in composer.json).

## 2. Install helper

```bash
php artisan reportkit:install --with-config --publish-assets
```

This publishes `config/reportkit.php` and copies UI assets into `public/vendor/reportkit/` when the sibling `@lorapok-labs/reportkit-ui` package is available (or use `vendor:publish --tag=reportkit-assets` after embedding assets).

Docs: https://reportkit.lorapok.tech/docs/0.1/getting-started/installation

## 3. Scaffold a NEW report only

```bash
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --dry-run
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --layout=layouts.app
composer dump-autoload
```

Domain SQL stays in `app/Repositories/Reports`. Prefer `ReportKit::merged()` + `ReportKit::connection()` for dual-DB.

**Do not rewrite existing host reports until you explicitly migrate them.**

## 4. Definitions folder

Create `app/Reports/` — the provider recursively requires `*.php` on boot (`reportkit.definitions_path`).

## 5. Optional routes helper

Set `routes.enabled` to `true` in `config/reportkit.php`, then call `ReportKit::routes()`:

- `reportkit/{slug}/data`
- `reportkit/{slug}/weeks`
- `reportkit/{slug}/rows`
- `reportkit/{slug}/trace` (when `routes.trace` is true)
