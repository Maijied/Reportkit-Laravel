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
