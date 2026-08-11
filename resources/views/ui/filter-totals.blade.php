{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * filter-totals — Blade UI partial.
--}}

{{-- Credit / debit strip — updated by ReportKit.kpi.apply / browse summary --}}
@if(empty($reportFlags) || !empty($reportFlags['ledger']) || !empty($reportFlags['filter_totals']))
<div class="rk-filter-totals">
    <div class="rk-filter-totals-item" data-rk-kpi="total_credit">
        <span class="rk-filter-totals-label">{{ isset($creditLabel) ? $creditLabel : 'Total credit' }}</span>
        <span class="rk-filter-totals-value rk-kpi-value">{{ isset($totalCredit) ? $totalCredit : '—' }}</span>
    </div>
    <div class="rk-filter-totals-item" data-rk-kpi="total_debit">
        <span class="rk-filter-totals-label">{{ isset($debitLabel) ? $debitLabel : 'Total debit' }}</span>
        <span class="rk-filter-totals-value rk-kpi-value">{{ isset($totalDebit) ? $totalDebit : '—' }}</span>
    </div>
    @if(!empty($showBalance))
    <div class="rk-filter-totals-item" data-rk-kpi="current_balance">
        <span class="rk-filter-totals-label">{{ isset($balanceLabel) ? $balanceLabel : 'Balance' }}</span>
        <span class="rk-filter-totals-value rk-kpi-value">{{ isset($currentBalance) ? $currentBalance : '—' }}</span>
    </div>
    @endif
</div>
@endif
