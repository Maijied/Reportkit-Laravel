{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * download-status — Blade UI partial.
--}}

{{-- Download ETA / status bar (Phase E2) --}}
<div class="rk-download-status {{ !empty($hidden) ? 'is-hidden' : '' }}" id="{{ isset($id) ? $id : 'rkDownloadStatus' }}">
    <div class="rk-download-status-head">
        <span class="rk-download-status-label">{{ isset($label) ? $label : 'Preparing download…' }}</span>
        <span class="rk-download-status-eta" id="{{ isset($etaId) ? $etaId : 'rkDownloadEta' }}"></span>
    </div>
    <div class="rk-download-status-bar"><div class="rk-download-status-fill" style="width:0%"></div></div>
</div>
