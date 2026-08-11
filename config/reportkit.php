<?php

return [
    'brand' => [
        'name' => 'ReportKit',
        'pdf_disclaimer' => 'This document was generated for authorized use only.',
        'accent' => '#0b7a4b',
    ],

    'routes' => [
        'enabled' => false,
        'prefix' => 'reportkit',
        'middleware' => [],
        'trace' => false,
    ],

    'definitions_path' => 'app/Reports',

    'date' => [
        'max_months' => 6,
    ],

    'table' => [
        'default_page_length' => 25,
    ],

    'dedupe' => [
        'key' => null,
    ],
];
