# Laravel Envato

[![Latest Version on Packagist](https://img.shields.io/packagist/v/infyomlabs/laravel-envato.svg?style=flat-square)](https://packagist.org/packages/infyomlabs/laravel-envato)
[![Total Downloads](https://img.shields.io/packagist/dt/infyomlabs/laravel-envato.svg?style=flat-square)](https://packagist.org/packages/infyomlabs/laravel-envato)
![GitHub Actions](https://github.com/infyomlabs/laravel-envato/actions/workflows/main.yml/badge.svg)

Laravel Wrapper for calling [Envato API](https://build.envato.com/api)

## Installation

You can install the package via composer:

```bash
composer require infyomlabs/laravel-envato
```

You can optionally publish a configuration file by running the following command:

```bash
php artisan vendor:publish --provider="InfyOmLabs\LaravelEnvato\LaravelEnvatoServiceProvider"
```

## Usage

### Configuration

Register your app with Envato and get the app credentials. After that Set the following values into your `.env` file:

```
ENVATO_CLIENT_ID=
ENVATO_CLIENT_SECRET=
ENVATO_REDIRECT_URI=
```

### Implement User Authentication

Redirect user to the Envato authentication by the following code,

```php
$redirectUri = LaravelEnvato::auth()->authRedirect();

return response()->redirectTo($redirectUri);
```

It will redirect the user to the Envato Authentication page. After successful authentication, it will redirect back to
the `ENVATO_REDIRECT_URI` specified in the `.env` file. Envato will return the authentication code by which we can
retrieve the auth credentials of the user.

Put the following code to retrieve auth credentials:

```php
$code = $request->get('code');

$authCredentials = LaravelEnvato::auth()->handleRedirect($code);
```

It will return the instance of `InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials` which will contain the following
attributes:

* `accessToken (string)`
* `refreshToken (string)`
* `expiresIn (Carbon DateTime Object)`

You can save these values wherever you want as per your convenience. Remember, you will need these credentials in future
to make API calls.

### Calling APIs

#### Load Auth Session

Before using any APIs, you need to load the auth session by the credentials that you got from the previous step. You can
do that by the following code:

```php

$envatoCredentials = new \InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials([
    'accessToken' => '',
    'refreshToken' => '',
    'expiresIn' => '',
]);

LaravelEnvato::auth()->loadAuthSession($envatoCredentials);
```

#### Make API Call

```php
$response = LaravelEnvato::items()->getItem("26344507");

$result = $response->body;
```

It will return the instance of `\InfyOmLabs\LaravelEnvato\Client\EnvatoResponse` which will contain the following attributes:

* `statusCode (int)`
* `headers (array)`
* `body (mixed)`
* `retryAfter (int)` - Only if rate limit exception was thrown

You can retrieve a response by getting the `body` attribute.

#### Rate Limit Exception

If you are hitting a rate limiting as per the policy of Envato, package will throw `InfyOmLabs\LaravelEnvato\Exceptions\EnvatoRateLimitException` exception.
You can use the `retryAfter` attribute to wait for the specified time and then try again to make an API call.

#### Refresh Token

The package will automatically try to refresh the token if it is expired and set the new credentials in Auth Session.
You can listen for the event `InfyOmLabs\LaravelEnvato\Events\EnvatoCredentialsRefreshed` and refresh the credentials in your storage.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email labs@infyom.in instead of using the issue tracker.

## Credits

- [InfyOm Technologies](https://github.com/infyomlabs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
