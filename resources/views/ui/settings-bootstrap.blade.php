{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * settings-bootstrap — Blade UI partial.
--}}

{{-- Inline browser-safe settings — avoids extra round-trip (Phase A2/A3) --}}
@php
    $rkReportId = $reportkitReportId ?? null;
    $rkSettingsPayload = \ReportKit\Core\Settings\ReportBrowserSettings::payload(
        app(),
        dirname(__DIR__, 3) . '/config/reportkit.php',
        $rkReportId
    );
    $rkSettingsJson = \ReportKit\Core\Settings\BrowserSettingsBuilder::encode($rkSettingsPayload);
@endphp
<script>
window.__REPORTKIT_SETTINGS__ = {!! $rkSettingsJson !!};
</script>
