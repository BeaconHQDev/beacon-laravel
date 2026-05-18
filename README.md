# beacon-laravel

Official Laravel SDK for [Beacon](https://beaconhq.dev) — self-hosted error tracking. Wraps [beaconhq/beacon-php](https://github.com/BeaconHQDev/beacon-php) with auto-discovery, a config file, a Facade, and first-class Laravel 11+ exception handler integration.

## Installation

```bash
composer require beaconhq/beacon-laravel
```

Laravel auto-discovers the service provider and `Beacon` facade. No manual registration needed.

## Configuration

### Publish the config file

```bash
php artisan vendor:publish --tag=beacon-config
```

This creates `config/beacon.php` in your application.

### Set up your DSN in `.env`

```env
BEACON_DSN=https://pub_YOUR_KEY@api.beaconhq.dev/YOUR_PROJECT_ID
BEACON_RELEASE=1.0.0        # optional — tag events with a release/version
```

Find your DSN in the Beacon dashboard under **Project Settings → API Keys**.

## Laravel 11+ Exception Handler Wiring

Open `bootstrap/app.php` and add the Beacon integration inside `withExceptions`:

```php
use BeaconHQ\Laravel\Integration;

->withExceptions(function (Exceptions $exceptions) {
    Integration::handles($exceptions);
})
```

This registers a `reportable` handler so every exception Laravel reports is automatically forwarded to Beacon.

## Manual Usage

You can capture errors and messages anywhere in your application using the `Beacon` facade:

```php
use BeaconHQ\Laravel\Facades\Beacon;

// Capture an exception manually
try {
    riskyOperation();
} catch (\Throwable $e) {
    Beacon::captureException($e, ['order_id' => $orderId]);
}

// Capture a message
Beacon::captureMessage('Payment gateway timed out', 'warning');

// Set user context (attached to all subsequent events)
Beacon::setUser(
    id: (string) auth()->id(),
    email: auth()->user()?->email,
    name: auth()->user()?->name,
);

// Attach tags
Beacon::setTag('tenant', $tenantSlug);
```

### Levels

`debug`, `info`, `warning`, `error`, `fatal`

## Before Send Hook

Filter or modify events before they leave your server. Set `before_send` in `config/beacon.php`:

```php
'before_send' => function (array $payload): ?array {
    // Drop health-check noise
    if (str_contains($payload['message'] ?? '', 'health check')) {
        return null;
    }

    // Scrub sensitive fields
    unset($payload['extra']['api_secret']);

    return $payload;
},
```

Return `null` to drop the event. Any exception thrown inside the hook is silently swallowed — the event is still sent.

## Disabling Beacon

Leave `BEACON_DSN` blank (or unset) to disable all error reporting:

```env
BEACON_DSN=
```

This is the recommended approach for local development environments.

## License

MIT
