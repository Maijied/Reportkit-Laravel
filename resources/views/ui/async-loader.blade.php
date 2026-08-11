{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * async-loader — Blade UI partial.
--}}

{{-- Async prepare overlay — optional Kit-Larva animation from config --}}
@php
    $brand = config('reportkit.brand', []);
    $mascotEnabled = data_get($brand, 'mascot_enabled', true);
    $loaderFile = data_get($brand, 'loader_animation', 'kit-larva-prepare.gif');
    $loaderSrc = data_get($brand, 'loader_url');
    $loaderBase = data_get($brand, 'loader_path', 'vendor/reportkit/img');
    if ($mascotEnabled && !$loaderSrc && $loaderFile) {
        $loaderSrc = asset(trim($loaderBase, '/') . '/' . ltrim($loaderFile, '/'));
    }
@endphp
<div id="rkAsyncLoading" class="rk-async-loading" style="display:none;" aria-live="polite" aria-busy="true">
    <div class="rk-async-loading-inner">
        @if ($mascotEnabled && $loaderSrc)
            <img
                class="rk-async-mascot"
                src="{{ $loaderSrc }}"
                alt=""
                width="88"
                height="88"
                loading="eager"
                aria-hidden="true"
            />
        @endif
        <div class="rk-async-loading-msg">Preparing report…</div>
        <div class="rk-progress"><div class="rk-progress-bar" style="width:0%"></div></div>
    </div>
</div>
