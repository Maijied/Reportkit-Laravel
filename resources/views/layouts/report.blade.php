{{-- ReportKit layout shell (CAS design order). Host fills $slots. --}}
{{-- Include reportkit.css from @reportkit/ui --}}
<div class="rk-page">
    @include('reportkit::ui.page-head')
    @include('reportkit::ui.filter-panel')
    @include('reportkit::ui.filter-summary')
    @include('reportkit::ui.kpi-row')
    <div class="rk-results">
        @yield('reportkit.results')
    </div>
    @include('reportkit::ui.sync-loader')
    @include('reportkit::ui.async-loader')
    @yield('reportkit.send')
    @yield('reportkit.howto')
</div>
