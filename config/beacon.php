<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Beacon DSN
    |--------------------------------------------------------------------------
    |
    | Your project's Data Source Name. Find it under Project Settings → API Keys
    | in the Beacon dashboard. Leave blank (or unset) to disable Beacon entirely,
    | which is useful for local development.
    |
    | Format: https://pub_KEY@api.beaconhq.dev/PROJECT_ID
    |
    */

    'dsn' => env('BEACON_DSN'),

    /*
    |--------------------------------------------------------------------------
    | Release
    |--------------------------------------------------------------------------
    |
    | Tag events with the current release / version of your application.
    | Typically a git SHA, tag, or semantic version string.
    |
    */

    'release' => env('BEACON_RELEASE'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The application environment in which events are captured. Defaults to
    | your APP_ENV value.
    |
    */

    'environment' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Before Send
    |--------------------------------------------------------------------------
    |
    | An optional callable that is invoked before every event is sent. Receives
    | the payload array and must return the (modified) payload, or null to drop
    | the event entirely.
    |
    | Example:
    |   'before_send' => function (array $payload): ?array {
    |       if ($payload['environment'] === 'local') return null;
    |       return $payload;
    |   },
    |
    */

    'before_send' => null,

];
