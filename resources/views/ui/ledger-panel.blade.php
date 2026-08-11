{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * ledger-panel — Blade UI partial.
--}}

{{-- Ledger DataTable panel with loading overlay (Phase K3) --}}
@if(empty($reportFlags) || !empty($reportFlags['ledger']) || !empty($reportFlags['datatables']))
@php
    $tableId = isset($tableId) ? $tableId : 'rkLedgerTable';
    $enhanced = !empty($enhanced) || (function_exists('config') && config('reportkit.design.ledger_enhanced', false));
@endphp
<div class="rk-panel rk-ledger-panel">
    <div class="rk-panel-head">
        <h2 class="rk-panel-title">{{ isset($title) ? $title : 'Ledger' }}</h2>
        <div class="rk-panel-toolbar">
            @yield('reportkit.ledger-toolbar')
        </div>
    </div>
    <div class="rk-panel-body">
        <div class="rk-ledger-table-wrap">
            <div class="rk-table-loader" id="{{ isset($loaderId) ? $loaderId : 'rkTableLoader' }}" aria-hidden="true">
                <span class="rk-table-loader-msg">{{ isset($loaderMessage) ? $loaderMessage : 'Loading…' }}</span>
            </div>
            <div class="rk-table-x {{ $enhanced ? 'rk-ledger-table--enhanced' : '' }}">
                <table id="{{ $tableId }}" class="display rk-ledger-table" style="width:100%"></table>
            </div>
        </div>
    </div>
</div>
@endif
