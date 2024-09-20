<?php

return [
    'endpoint' => [
        'localhost' => [
            'host' => env('SOLR_HOST', '127.0.0.1'),
            'port' => env('SOLR_PORT', 8983),
            'path' => '/',
            'core' => env('SOLR_CORE', 'advertisement_portal_core'),
        ]
    ]
];
