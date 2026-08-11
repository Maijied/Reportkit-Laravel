{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * txn-pill — Blade UI partial.
--}}

{{-- Transaction type badge (Phase K5) — include with type + optional label --}}
@php
    $type = isset($type) ? $type : 'unknown';
    $label = isset($label) ? $label : $type;
    $classMap = isset($classMap) ? $classMap : (function_exists('config') ? config('reportkit.table.txn_type_classes', []) : []);
    $pillClass = isset($classMap[$type]) ? $classMap[$type] : 'rk-txn-pill--default';
@endphp
<span class="rk-txn-pill {{ $pillClass }}" data-txn-type="{{ $type }}">{{ $label }}</span>
