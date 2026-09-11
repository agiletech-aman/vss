<?php

// ═══════════════════════════════════════════════════════════════
// FILE: config/external-apis.php
// ═══════════════════════════════════════════════════════════════

return [

    /*
    |--------------------------------------------------------------------------
    | Camera / CCTV APIs  (new.cwcnewcctv.in)
    |--------------------------------------------------------------------------
    */
    'camera_dysfunctional'    => env('API_CAMERA_DYSFUNCTIONAL',    'https://new.cwcnewcctv.in/api/v1/cameras/dysfunctional'),
    'camera_by_region'        => env('API_CAMERA_BY_REGION',        'https://new.cwcnewcctv.in/api/v1/cameras/by-region-grouped'),
    'camera_by_warehouse'     => env('API_CAMERA_BY_WAREHOUSE',     'https://new.cwcnewcctv.in/api/v1/cameras/by-warehouse-grouped'),
    'camera_summary'          => env('API_CAMERA_DASHBOARD_SUMMARY', 'https://new.cwcnewcctv.in/api/v1/cameras/summary'),
    'camera_warehouse_search' => env('API_CAMERA_WAREHOUSE_SEARCH', 'https://new.cwcnewcctv.in/api/v1/cameras/search/warehouse'),

    /*
    |--------------------------------------------------------------------------
    | CO2 / PH3 / Fire / Smoke / Rodent  (co2ph3master.ajeevi.in)
    |--------------------------------------------------------------------------
    */
    'co2_summary'             => env('API_CO2_SUMMARY',       'https://co2ph3master.agiletech.net.in/api/master-alert-summary/dashboard'),
    'camera_alerts'           => env('API_CAMERA_ALERTS',     'https://co2ph3master.ajeevi.in/api/camera-alerts'),
    'master_alerts'           => env('API_MASTER_ALERTS',     'https://co2ph3master.agiletech.net.in/api/master-alerts'),
    'alert_dashboard'         => env('API_ALERT_DASHBOARD',   'https://co2ph3master.ajeevi.in/api/camera-summary/dashboard'),

    // Dedicated state / location endpoints  ← NEW
    'master_alert_states'     => env('API_MASTER_ALERT_STATES', 'https://co2ph3master.agiletech.net.in/api/master-alerts/states'),
    // Locations URL is built dynamically:  master_alert_states + '/{state}/locations'

    /*
    |--------------------------------------------------------------------------
    | FRS & Sack Counting
    |--------------------------------------------------------------------------
    */
    'frs_base'                => env('API_FRS_BASE',          'https://frsbag.cwcnewiot.in/frs'),
    'frs_unknown'             => env('API_FRS_UNKNOWN',       'https://frsbag.cwcnewiot.in/frs/all_region_unknown_person_count'),
    'sack_base'               => env('API_SACK_BASE',         'https://frsbag.cwcnewiot.in/sack'),
    'sack_count'              => env('API_SACK_COUNT',        'https://frsbag.cwcnewiot.in/sack/all-region-sack-count'),
    'sack_data'               => env('API_SACK_DATA',         'https://frsbag.cwcnewiot.in/sack/data'),
    'sack_region_count'       => env('API_SACK_REGION_COUNT', 'https://frsbag.cwcnewiot.in/sack/region-sack-count'),

    /*
    |--------------------------------------------------------------------------
    | Cavisson NMS
    |--------------------------------------------------------------------------
    */
    'cavisson_base'           => env('CAVISSON_BASE_URL', 'https://cwcnms.in'),
    'cavisson_sid'            => env('CAVISSON_SID',      'cwc'),

    /*    |--------------------------------------------------------------------------
    | NMS API Endpoints (nms.cwcnewcctv.in)
    |-------------------------------------------------------------------------- */
    'nms_api_base'            => env('NMS_API_BASE', 'https://nms.cwcnewcctv.in/api/nms/v1'),

    /*
    |--------------------------------------------------------------------------
    | Timeouts (seconds)
    |--------------------------------------------------------------------------
    */
    'timeout_default'         => env('API_TIMEOUT_DEFAULT', 20),
    'timeout_slow'            => env('API_TIMEOUT_SLOW',    30),
    'timeout_fast'            => env('API_TIMEOUT_FAST',    10),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL (seconds)
    |--------------------------------------------------------------------------
    */
    'cache_dashboard'         => env('API_CACHE_DASHBOARD',    300),
    'cache_co2_summary'       => env('API_CACHE_CO2_SUMMARY',  120),
    'cache_nms_map'           => env('API_CACHE_NMS_MAP',      300),
    'cache_nms_area'          => env('API_CACHE_NMS_AREA',      60),
    'cache_states'            => env('API_CACHE_STATES',        300),
    'cache_locations'         => env('API_CACHE_LOCATIONS',     300),

];
