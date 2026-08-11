{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * prepare-loader — LLDP prepare overlay (progress, ETA, cancel). Canonical name for async prepare.
--}}
@include('reportkit::ui.async-loader', array_merge(get_defined_vars(), [
    'overlayId' => isset($overlayId) ? $overlayId : 'rkAsyncLoading',
]))
