{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * alert — Blade UI partial.
--}}

{{-- Inline alert region (Phase E2) --}}
<div class="rk-alert {{ !empty($tone) ? 'rk-alert--' . $tone : '' }}" id="{{ isset($id) ? $id : 'rkAlert' }}" role="alert" @if(empty($message)) hidden @endif>
    <span class="rk-alert-message">{{ isset($message) ? $message : '' }}</span>
    @if(!empty($dismissible))
    <button type="button" class="rk-alert-dismiss" data-rk-alert-dismiss aria-label="Dismiss">&times;</button>
    @endif
</div>
