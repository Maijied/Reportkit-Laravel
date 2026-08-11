{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * activity-log — Blade UI partial.
--}}

{{-- Activity log panel — enable with logging.enabled + logging.panel=local --}}
@if(!empty($enabled))
<div class="rk-panel rk-activity-log-panel">
    <div class="rk-panel-head">
        <h3 class="rk-panel-title">Activity</h3>
        <button type="button" class="rk-btn rk-btn--ghost rk-log-clear" data-rk-log-clear>Clear</button>
    </div>
    <div class="rk-activity-log" aria-live="polite"></div>
</div>
<script>
(function () {
    if (!window.ReportKit || !ReportKit.log) { return; }
    ReportKit.log.renderPanel('.rk-activity-log');
    var btn = document.querySelector('[data-rk-log-clear]');
    if (btn) {
        btn.addEventListener('click', function () { ReportKit.log.clear(); });
    }
})();
</script>
@endif
