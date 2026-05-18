<?php

namespace BeaconHQ\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void init(array $options)
 * @method static void setUser(?string $id = null, ?string $email = null, ?string $name = null)
 * @method static void setTag(string $key, string $value)
 * @method static void captureException(\Throwable $e, array $extra = [])
 * @method static void captureMessage(string $message, string $level = 'info', array $extra = [])
 * @method static void reset()
 *
 * @see \BeaconHQ\Beacon
 */
class Beacon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BeaconHQ\Beacon::class;
    }
}
