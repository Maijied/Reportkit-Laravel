<?php

/**
 * Lorapok ReportKit
 * Copyright (c) 2026 Lorapok Labs (https://lorapok.tech)
 * Licensed under the Lorapok Non-Commercial License 1.0 (Lorapok-NCL-1.0)
 *
 * reportkit.php — package configuration defaults.
 */

return [
    'brand' => [
        'name' => 'ReportKit',
        'accent' => '#0b7a4b',
        'mascot_enabled' => true,
        'mascot_name' => 'Kit-Larva',
        'logo_path' => null,
        'loader_animation' => 'kit-larva-prepare.gif',
        'loader_path' => 'vendor/reportkit/img',
        'loader_url' => null,
        'pdf_disclaimer' => 'This document was generated for authorized use only.',
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
        'ledger_max_days' => 31,
        'block_future_dates' => false,
        'auto_open_end_date' => false,
    ],

    'prepare' => [
        'concurrency' => 3,
        'day_label_under_days' => 7,
        'ajax_timeout_ms' => 120000,
    ],

    'store' => [
        'session_persist_max_bytes' => 1500000,
        'storage_key_prefix' => 'reportkit_',
        'ttl_ms' => 3600000,
        'encryption_enabled' => true,
    ],

    'export' => [
        'excel_soft_max_rows' => 25000,
        'pdf_single_pass_max_rows' => 105303,
        'pdf_proven_single_max_rows' => 105303,
        'pdf_single_file_max_rows' => 40000,
        'pdf_rows_per_volume' => 25000,
        'pdf_chunk_rows' => 80,
        'csv_chunk_rows' => 400,
        'excel_chunk_rows' => 400,
        'stream_csv_row_threshold' => 50000,
        'memory_limit' => '2048M',
        'rows_response_shape' => 'array',
    ],

    'mail' => [
        'enabled' => true,
        'hard_attach_max_bytes' => 26214400,
        'email_max_length' => 254,
        'view' => 'reportkit::emails.send',
    ],

    'notifications' => [
        'ping_enabled' => true,
        'sound_muted_key' => 'reportkit_sound_muted',
    ],

    'logging' => [
        'enabled' => false,
        'panel' => 'local',
        'level' => 'info',
        'buffer_max' => 200,
        'sample_rate' => 1.0,
        'include_in_ajax' => false,
        'redact' => ['password', 'token', '_token'],
    ],

    'design' => [
        'theme' => 'cas',
        'dual_class_compat' => true,
        'ledger_enhanced' => false,
    ],

    'table' => [
        'page_limit_max' => 10000,
        'default_page_length' => 25,
        'length_menu' => [10, 25, 50, 100],
        'txn_type_classes' => [
            'recharge' => 'rk-txn-pill--recharge',
            'ticket_sell' => 'rk-txn-pill--sell',
            'ticket_cancel' => 'rk-txn-pill--cancel',
            'admin_debit' => 'rk-txn-pill--debit',
            'balance_reset' => 'rk-txn-pill--reset',
        ],
    ],

    'dedupe' => [
        'key' => null,
    ],

    'features' => [
        'async_prepare' => true,
        'ledger_browse' => false,
        'activity_log_panel' => false,
        'pattern' => 'lldp',
    ],
];
