<?php

return [
    'cookie' => [
        'name' => 'cookie_consent',
        'duration' => 60 * 24 * 365, // 1 year
        'domain' => null,
    ],

    'policy' => '/cookie-policy',

    'translations' => [
        'namespace' => 'cookieConsent',
    ],

    'blade' => [
        'view' => 'frontend.cookies.consent',
    ],
]; 