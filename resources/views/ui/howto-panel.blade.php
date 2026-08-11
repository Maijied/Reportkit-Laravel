{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * howto-panel — Blade UI partial.
--}}

{{-- Collapsible how-to panel (Phase E2) --}}
@if(empty($reportFlags) || !empty($reportFlags['howto']))
<details class="rk-howto-panel" {{ !empty($open) ? 'open' : '' }}>
    <summary class="rk-howto-summary">{{ isset($title) ? $title : 'How to use this report' }}</summary>
    <div class="rk-howto-body">
        @if(!empty($content))
            {!! $content !!}
        @else
            @yield('reportkit.howto-content')
        @endif
    </div>
</details>
@endif
