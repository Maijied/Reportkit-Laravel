{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * page-head — Blade UI partial.
--}}

{{-- Page header: kicker + title + subtitle (+ optional pill) --}}
@if (!empty($reportTitle) || !empty($reportKicker))
<div class="rk-page-head">
    @if (!empty($reportKicker))
        <div class="rk-kicker">{{ $reportKicker }}</div>
    @endif
    <h1 class="rk-title">
        {{ !empty($reportTitle) ? $reportTitle : 'Report' }}
        @if (!empty($reportPill))
            <span class="rk-pill">{{ $reportPill }}</span>
        @endif
    </h1>
    @if (!empty($reportSubtitle))
        <p class="rk-sub">{{ $reportSubtitle }}</p>
    @endif
</div>
@endif
