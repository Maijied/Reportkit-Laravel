{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * send-panel — 4-step email send stepper with upload progress.
--}}
@if(!empty($reportFlags['email']))
@php
    $panelId = isset($panelId) ? $panelId : 'rkSendPanel';
@endphp
<div class="rk-panel rk-send-panel" id="{{ $panelId }}">
    <div class="rk-panel-head">
        <h3 class="rk-panel-title">Send report</h3>
        <button type="button" class="rk-notify-bell rk-notify-bell--idle" id="rkNotifyBell" title="Notification status" aria-label="Notification status"></button>
    </div>
    <div class="rk-panel-body">
        <ol class="rk-send-steps">
            <li class="rk-send-step is-active" data-step="1">Enter email</li>
            <li class="rk-send-step" data-step="2">Build attachment</li>
            <li class="rk-send-step" data-step="3">Upload &amp; send</li>
            <li class="rk-send-step" data-step="4">Done</li>
        </ol>
        <div class="rk-send-progress is-hidden" id="rkSendUploadProgress">
            <div class="rk-send-progress-bar"><div class="rk-send-progress-fill" style="width:0%"></div></div>
            <span class="rk-send-progress-label">Uploading…</span>
        </div>
        <form id="rkSendForm" class="rk-send-form" novalidate>
            <label class="rk-field-label" for="rkSendEmail">Recipient</label>
            <input type="email" id="rkSendEmail" name="email" class="rk-field-input" maxlength="254" placeholder="ops@example.com" required>
            <div class="rk-send-actions">
                <button type="submit" class="rk-btn rk-btn-send" id="rkSendSubmitBtn">Send now</button>
            </div>
        </form>
    </div>
</div>
@endif
