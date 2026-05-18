<?php

namespace BeaconHQ\Laravel;

use BeaconHQ\Beacon;
use Illuminate\Support\ServiceProvider;

class BeaconServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/beacon.php', 'beacon');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/beacon.php' => config_path('beacon.php'),
        ], 'beacon-config');

        $dsn = config('beacon.dsn');
        if (!$dsn) {
            return;
        }

        Beacon::init([
            'dsn'         => $dsn,
            'release'     => config('beacon.release'),
            'environment' => config('beacon.environment', app()->environment()),
            'before_send' => config('beacon.before_send'),
        ]);
    }
}
