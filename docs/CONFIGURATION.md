# Configuration

Publish the config file:

```bash
php artisan reportkit:install --with-config
# or
php artisan vendor:publish --tag=reportkit-config
```

## Keys

| Key | Default | Purpose |
|-----|---------|---------|
| `brand.name` | ReportKit | Product name in UI |
| `brand.accent` | `#0b7a4b` | Accent color |
| `routes.enabled` | `false` | Load opt-in HTTP routes |
| `routes.prefix` | `reportkit` | Route prefix |
| `routes.middleware` | `[]` | Middleware stack |
| `routes.trace` | `false` | Enable `/trace` debug endpoint |
| `definitions_path` | `app/Reports` | Auto-loaded definition folder (recursive) |
| `date.max_months` | `6` | Date range ceiling |
| `table.default_page_length` | `25` | DataTables default page size |
| `dedupe.key` | `null` | Optional default dedupe key |

## Routes

When `routes.enabled` is true, call `ReportKit::routes()`:

- `GET {prefix}/{slug}/data`
- `GET {prefix}/{slug}/weeks`
- `GET {prefix}/{slug}/rows`
- `GET {prefix}/{slug}/trace` (if `routes.trace`)
