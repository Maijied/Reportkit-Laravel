{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * filter-panel — Blade UI partial.
--}}

{{-- Filter panel wrapper — yield fields from the page --}}
<div class="rk-filter-pan search-pan" id="search-pan">
    @yield('reportkit.filters')
</div>
