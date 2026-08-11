{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * async-loader — prepare overlay with progress, ETA, and cancel.
--}}
@php
    $mascotEnabled = array_get(config('reportkit.brand', array()), 'mascot_enabled', true);
    $loaderFile = array_get(config('reportkit.brand', array()), 'loader_animation', 'kit-larva-prepare.gif');
    $loaderSrc = array_get(config('reportkit.brand', array()), 'loader_url', null);
    $loaderBase = array_get(config('reportkit.brand', array()), 'loader_path', 'img/reportkit');
    if ($mascotEnabled && !$loaderSrc && $loaderFile) {
        $loaderSrc = asset(trim($loaderBase, '/') . '/' . ltrim($loaderFile, '/'));
    }
    $overlayId = isset($overlayId) ? $overlayId : 'rkAsyncLoading';
@endphp
<div id="{{ $overlayId }}" class="rk-async-loading" style="display:none;" aria-live="polite" aria-busy="true">
    <div class="rk-async-loading-inner">
        @if ($mascotEnabled && $loaderSrc)
            <img class="rk-async-mascot" src="{{ $loaderSrc }}" alt="" width="88" height="88" loading="eager" aria-hidden="true" />
        @endif
        <div class="rk-async-loading-msg">Preparing report…</div>
        <div class="rk-async-progress-meta">
            <span class="rk-async-loading-percent">0%</span>
            <span class="rk-async-loading-eta">estimating…</span>
        </div>
        <div class="rk-progress"><div class="rk-progress-bar" style="width:0%"></div></div>
        <button type="button" class="rk-btn rk-btn-cancel rk-async-cancel" id="rkPrepareCancelBtn">Cancel</button>
    </div>
</div>
