# Multiple databases (Laravel)

See also `reportkit/core` docs/MULTI-DATABASE.md.

```php
use ReportKit\Laravel\Facades\ReportKit;

$source = ReportKit::merged([
    ReportKit::connection('mysql', function ($q, $f) {
        return $q->from('trips')
            ->whereBetween('booked_at', [$f['start_date'], $f['end_date']]);
    }),
    ReportKit::connection('mysql_archive', function ($q, $f) {
        return $q->from('trips')
            ->whereBetween('booked_at', [$f['start_date'], $f['end_date']]);
    }),
])->dedupeBy('trip_id')->orderBy('booked_at', 'desc');

$rows = $source->getRows($filters);
```
