{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * filter-summary — Blade UI partial.
--}}

{{-- Active filter summary strip --}}
@if (!empty($filterSummary) && is_array($filterSummary))
<div class="rk-filter-summary">
    <div class="rk-filter-summary-grid">
        @foreach ($filterSummary as $item)
            <div class="rk-meta">
                <div class="rk-meta-label">{{ isset($item['label']) ? $item['label'] : '' }}</div>
                <div class="rk-meta-value">{{ isset($item['value']) ? $item['value'] : '—' }}</div>
            </div>
        @endforeach
    </div>
</div>
@endif
