{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * report — ReportKit layout shell (CAS design order). Host fills $slots.
 * Pass $reportFlags from definition->flags to gate partials and JS bundles.
--}}
@include('reportkit::ui.settings-bootstrap')
<div class="rk-page">
    @include('reportkit::ui.page-head')
    @include('reportkit::ui.filter-panel')
    @if(empty($reportFlags) || !empty($reportFlags['sync']) || !empty($reportFlags['async_prepare']))
        @include('reportkit::ui.filter-summary')
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['kpi']))
        @include('reportkit::ui.kpi-row')
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['ledger']) || !empty($reportFlags['browse_prepared']))
        @include('reportkit::ui.filter-totals', ['showBalance' => !empty($reportFlags['ledger'])])
    @endif
    @include('reportkit::ui.action-bar', ['disabledUntilLoad' => !empty($reportFlags['browse_prepared']) || !empty($reportFlags['async_prepare'])])
    <div class="rk-results">
        @yield('reportkit.results')
    </div>
    @if(empty($reportFlags) || !empty($reportFlags['sync']))
        @include('reportkit::ui.sync-loader')
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['async_prepare']))
        @include('reportkit::ui.prepare-loader')
    @endif
    @if(!empty($reportFlags['email']))
        @include('reportkit::ui.send-panel')
    @endif
    @yield('reportkit.send')
    @if(!empty($reportFlags['howto']))
        @include('reportkit::ui.howto-panel')
    @endif
    @if(!empty($reportFlags['activity_log']))
        @include('reportkit::ui.activity-log', ['enabled' => function_exists('config') ? config('reportkit.logging.enabled', false) : false])
    @endif
</div>
