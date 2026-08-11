{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * action-bar — Blade UI partial.
--}}

{{-- Export / fetch action bar — buttons disabled until data load (K-R4) --}}
@if(empty($reportFlags) || !empty($reportFlags['excel']) || !empty($reportFlags['csv']) || !empty($reportFlags['pdf']) || !empty($reportFlags['email']) || !empty($reportFlags['async_prepare']))
@php
    $barId = isset($barId) ? $barId : 'rkActionBar';
    $disabled = !empty($disabledUntilLoad);
@endphp
<div class="rk-action-bar {{ $disabled ? 'is-disabled' : '' }}" id="{{ $barId }}">
    @if(empty($reportFlags) || !empty($reportFlags['async_prepare']))
        <button type="button" class="rk-btn rk-btn-fetch" id="rkPrepareBtn" {{ $disabled ? 'disabled' : '' }}>Fetch &amp; Prepare</button>
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['excel']))
        <button type="button" class="rk-btn rk-btn-excel" id="rkExcelBtn" data-rk-export="excel" {{ $disabled ? 'disabled' : '' }}>Excel</button>
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['csv']))
        <button type="button" class="rk-btn rk-btn-csv" id="rkCsvBtn" data-rk-export="csv" {{ $disabled ? 'disabled' : '' }}>CSV</button>
    @endif
    @if(empty($reportFlags) || !empty($reportFlags['pdf']) || !empty($reportFlags['print']))
        <button type="button" class="rk-btn rk-btn-pdf" id="rkPdfBtn" data-rk-export="pdf" {{ $disabled ? 'disabled' : '' }}>PDF</button>
    @endif
    @if(!empty($reportFlags['email']))
        <button type="button" class="rk-btn rk-btn-send" id="rkSendBtn" {{ $disabled ? 'disabled' : '' }}>Send</button>
    @endif
</div>
@endif
