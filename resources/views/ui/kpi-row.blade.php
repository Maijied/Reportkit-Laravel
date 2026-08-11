{{-- KPI cards --}}
@if (!empty($kpis) && is_array($kpis))
<div class="rk-kpi-row">
    @foreach ($kpis as $kpi)
        <div class="rk-kpi-card {{ !empty($kpi['tone']) ? 'is-' . $kpi['tone'] : '' }}">
            <div class="rk-kpi-label">{{ isset($kpi['label']) ? $kpi['label'] : '' }}</div>
            <div class="rk-kpi-value">{{ isset($kpi['value']) ? $kpi['value'] : '—' }}</div>
            @if (!empty($kpi['hint']))
                <div class="rk-kpi-hint">{{ $kpi['hint'] }}</div>
            @endif
        </div>
    @endforeach
</div>
@endif
