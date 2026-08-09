# reportkit/laravel

Laravel **5.5 → currently supported (12 / 13)** adapter for [ReportKit Core](https://github.com/Maijied/Reportkit-Core).

Auto-discovered provider + facade, CAS Blade views (`reportkit::`), and Artisan:

```bash
php artisan reportkit:install
php artisan reportkit:make Demo --route=admin/demo-report --preset=hybrid --dry-run
```

> PHP ≥ 7.0 · Pair with [`@reportkit/ui`](https://github.com/Maijied/Reportkit-UI)

For Laravel **4.1–5.4** use [`reportkit/laravel-legacy`](https://github.com/Maijied/Reportkit-Laravel-Legacy).

---

## Author

**Mohammad Maizied Hasan Majumder** \<mdshuvo40@gmail.com\>  
Founder & Principal Engineer at Lorapok Labs · Senior Software Engineer @ Shohoz Ltd

---

## Install

```bash
composer require reportkit/core reportkit/laravel
```

VCS until Packagist:

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

See [docs/INSTALL.md](docs/INSTALL.md).

## License

MIT © Mohammad Maizied Hasan Majumder / Lorapok Labs
