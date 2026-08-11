{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * send-panel — Blade UI partial.
--}}

{{-- Email send stepper shell (Phase E2) — host wires ReportKit.mail.send --}}
@if(!empty($reportFlags['email']))
<div class="rk-panel rk-send-panel" id="rkSendPanel">
    <div class="rk-panel-head">
        <h3 class="rk-panel-title">Send report</h3>
    </div>
    <div class="rk-panel-body">
        <ol class="rk-send-steps">
            <li class="rk-send-step is-active" data-step="1">Enter email</li>
            <li class="rk-send-step" data-step="2">Review attachment</li>
            <li class="rk-send-step" data-step="3">Confirm</li>
            <li class="rk-send-step" data-step="4">Sent</li>
        </ol>
        <form id="rkSendForm" class="rk-send-form" novalidate>
            <label class="rk-field-label" for="rkSendEmail">Recipient</label>
            <input type="email" id="rkSendEmail" name="email" class="rk-field-input" maxlength="254" placeholder="ops@example.com" required>
            <div class="rk-send-actions">
                <button type="submit" class="rk-btn rk-btn-send">Send now</button>
            </div>
        </form>
    </div>
</div>
@endif
