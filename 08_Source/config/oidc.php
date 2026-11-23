<?php

return [
    'driver_prefix' => 'oidc_',
    'connections' => [
        'keycloak' => [
            'provider' => 'keycloak',
            'server_url' => env('KEYCLOAK_SERVER_URL', 'http://127.0.0.1:8080'),
            'realm' => env('KEYCLOAK_REALM', 'sewakampus'),
            'client_id' => env('KEYCLOAK_CLIENT_ID'),
            'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
            'redirect' => env('KEYCLOAK_REDIRECT_URI', 'http://127.0.0.1:8000/auth/keycloak/callback'),
            'scopes' => ['openid', 'profile', 'email'],
        ],
    ],
];
