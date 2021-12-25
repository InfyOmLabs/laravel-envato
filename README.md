# Laravel Envato

[![Total Downloads](https://poser.pugx.org/infyomlabs/laravel-envato/downloads)](https://packagist.org/packages/infyomlabs/laravel-envato)
[![Monthly Downloads](https://poser.pugx.org/infyomlabs/laravel-envato/d/monthly)](https://packagist.org/packages/infyomlabs/laravel-envato)
[![Daily Downloads](https://poser.pugx.org/infyomlabs/laravel-envato/d/daily)](https://packagist.org/packages/infyomlabs/laravel-envato)
[![License](https://poser.pugx.org/infyomlabs/laravel-envato/license)](https://packagist.org/packages/infyomlabs/laravel-envato)

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

### Authentication

#### OAuth Authentication

Redirect user to the Envato authentication by the following code,

```php

use LaravelEnvato;

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

#### Persistent Authentication (Personal Token)

If your application do not want to access the personal data of the user, you can use the `personalToken` to make api calls.
In that case, you need to set `ENVATO_PERSONAL_TOKEN` in your `.env` file and then make ``InfyOmLabs\LaravelEnvato\Auth\EnvatoCredentials` manually by the following code:

```php
$authCredentials = new EnvatoCredentials();
$authCredentials->accessToken = config('laravel-envato.personal_token');
$authCredentials->refreshToken = "";
$authCredentials->expiresIn = now()->addHours(24);
```

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

## List of Implementing APIs

### Authentication

- [Authenticating with OAuth](https://build.envato.com/api/#oauth)
- [Authenticating with a Personal Token](https://build.envato.com/api/#token)

### Envato Market Catalog
 
[Search for items](https://build.envato.com/api/#search_getSearchItem)

```php
LaravelEnvato::items()->searchItems([
    'term' => 'InfyHMS',
    'site' => 'codecanyon.net',
]);
```

[Look up a single item](https://build.envato.com/api/#market_0_getCatalogItem)

```php
LaravelEnvato::items()->getItem("26344507");
```

### User Details
  
[A user's items by site](https://build.envato.com/api/#market_getUserItemsBySite)

```php
LaravelEnvato::items()->userItemsBySite("infyomlabs");
```

[User account details](https://build.envato.com/api/#market_getUser)

```php
LaravelEnvato::sales()->accountDetails("infyomlabs");
```

### Private User Details

[List an author's sales](https://build.envato.com/api/#market_0_getAuthorSales)

```php
LaravelEnvato::sales()->authorSales(1);
```

[Statement data](https://build.envato.com/api/#market_0_getUserStatement)

```php
LaravelEnvato::sales()->statement();
LaravelEnvato::sales()->statement(['page' => $this->page]);
LaravelEnvato::sales()->statement(['type' => 'Sale Refund', 'page' => $this->page]);
```

[Look up sale by code](https://build.envato.com/api/#market_0_getAuthorSale)

```php
LaravelEnvato::sales()->saleByCode("00000000-0000-0000-0000-000000000000");
```

[Get a user's username](https://build.envato.com/api/#market_getUserUsername)

```php
LaravelEnvato::user()->getUsername();
```

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
