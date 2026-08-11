{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * kpi-row — Blade UI partial.
--}}

{{-- KPI cards — use $kpi['key'] for ReportKit.kpi.apply(data-rk-kpi) --}}
@if (!empty($kpis) && is_array($kpis))
<div class="rk-kpi-row">
    @foreach ($kpis as $kpi)
        <div class="rk-kpi-card {{ !empty($kpi['tone']) ? 'is-' . $kpi['tone'] : '' }}"
             @if (!empty($kpi['key'])) data-rk-kpi="{{ $kpi['key'] }}" @endif>
            <div class="rk-kpi-label">{{ isset($kpi['label']) ? $kpi['label'] : '' }}</div>
            <div class="rk-kpi-value">{{ isset($kpi['value']) ? $kpi['value'] : '—' }}</div>
            @if (!empty($kpi['hint']))
                <div class="rk-kpi-hint">{{ $kpi['hint'] }}</div>
            @endif
        </div>
    @endforeach
</div>
@elseif(empty($reportFlags) || !empty($reportFlags['kpi']))
<div class="rk-kpi-row">
    <div class="rk-kpi-card" data-rk-kpi="current_balance">
        <div class="rk-kpi-label">Balance</div>
        <div class="rk-kpi-value">—</div>
    </div>
    <div class="rk-kpi-card" data-rk-kpi="total_credit">
        <div class="rk-kpi-label">Total credit</div>
        <div class="rk-kpi-value">—</div>
    </div>
    <div class="rk-kpi-card" data-rk-kpi="total_debit">
        <div class="rk-kpi-label">Total debit</div>
        <div class="rk-kpi-value">—</div>
    </div>
</div>
@endif
