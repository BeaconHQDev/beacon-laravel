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
            try {
                $request = app('request');
                if ($request && $request->getRequestUri()) {
                    Beacon::setContext(
                        url: $request->url(),
                        userAgent: $request->userAgent(),
                    );
                }
            } catch (\Throwable) {
                // Not in a request context (CLI, queues) — skip
            }

            Beacon::captureException($e);
        });
    }
}
