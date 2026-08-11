{{--
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * send — Blade UI partial.
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ isset($subject) ? $subject : 'Report export' }}</title>
</head>
<body style="font-family: Manrope, Arial, sans-serif; color: #1a2e24; line-height: 1.5;">
    <p style="color:#0b7a4b; font-weight:700;">ReportKit</p>
    <p>{{ isset($intro) ? $intro : 'Your requested report is attached.' }}</p>
    @if(!empty($disclaimer))
        <p style="font-size:12px; color:#64748b;">{{ $disclaimer }}</p>
    @endif
    <p style="font-size:12px; color:#64748b;">Generated for authorized use only — fictional demo data when applicable.</p>
</body>
</html>
