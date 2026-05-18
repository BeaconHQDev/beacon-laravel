<?php

namespace BeaconHQ\Laravel;

use BeaconHQ\Beacon;
use Illuminate\Foundation\Configuration\Exceptions;

class Integration
{
    /**
     * Wire Beacon into the Laravel 11+ exception handler.
     *
     * Call this inside the `withExceptions` callback in bootstrap/app.php:
     *
     *   ->withExceptions(function (Exceptions $exceptions) {
     *       \BeaconHQ\Laravel\Integration::handles($exceptions);
     *   })
     */
    public static function handles(Exceptions $exceptions): void
    {
        $exceptions->reportable(function (\Throwable $e) {
            Beacon::captureException($e);
        });
    }
}
