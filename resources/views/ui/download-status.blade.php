{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * download-status — compose/download ETA bar with ping, mute, and cancel.
--}}
@php
    $statusId = isset($id) ? $id : 'rkDownloadStatus';
    $etaId = isset($etaId) ? $etaId : 'rkDownloadEta';
@endphp
<div class="rk-download-status {{ !empty($hidden) ? 'is-hidden' : '' }}" id="{{ $statusId }}">
    <div class="rk-download-status-head">
        <span class="rk-download-status-label">{{ isset($label) ? $label : 'Preparing download…' }}</span>
        <span class="rk-download-status-eta" id="{{ $etaId }}"></span>
    </div>
    <div class="rk-download-status-bar"><div class="rk-download-status-fill" style="width:0%"></div></div>
    <div class="rk-download-status-actions">
        <button type="button" class="rk-btn rk-btn-ghost rk-notify-ping" id="rkNotifyPingBtn" title="Ping when ready">Ping</button>
        <button type="button" class="rk-btn rk-btn-ghost rk-notify-mute" id="rkNotifyMuteBtn" title="Mute sound">Mute</button>
        <button type="button" class="rk-btn rk-btn-cancel rk-download-cancel" id="rkDownloadCancelBtn">Cancel</button>
    </div>
</div>
