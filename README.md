# CSRF verification and session persistent through request/response headers.

This is a lightweight package which allow you to manage a session in a stateless communication (REST/API) when the
API domain and main web application domain are different.

E.g. 
- API hosted under: `api.foo.com`
- WEB hosted under: `tenant1.com`, `tenant2.com` etc.


In that case you cannot set cookie for different main domains 

[See why you cannot set cookie under different domain.](https://blog.webf.zone/ultimate-guide-to-http-cookies-2aa3e083dbae)



## Installation

You can install the package via composer:

```bash
composer require binarcode/laravel-stateless-session
```

## Usage

1. Trigger session, make a GET request to: `/api/csrf-header`. This will return a header with the session key and an optional header with CSRF token `XSRF-TOKEN`. 
The header name could be configured in: `stateless.header`

2. Use this header session key/value for every request you want to take care of the session.

3. If you want to benefit of the CSRF protection of your requests, you should add the follow middlewares to your routes:
```php
use Binarcode\LaravelStatelessSession\Http\Middleware\StatelessStartSession;
use Binarcode\LaravelStatelessSession\Http\Middleware\StatelessVerifyCsrfToken;

->middleware([
    StatelessStartSession::class,
    StatelessVerifyCsrfToken::class,
]);
```

You can create a middleware group in your Http\Kernel with these 2 routes as:

```php
protected $middlewareGroups = [
// ...
    'stateless.csrf' => [
        StatelessStartSession::class,
        StatelessVerifyCsrfToken::class,
    ],
// ...
]
```

Now the server will return 419 (Page expired code).
 
Unless you send back a request header named: `X-CSRF-TOKEN` with the value received by the first GET request in the `XSRF-TOKEN` header.

Done.

- At this point you have CSRF protection. 

- And you can play with `SessionManager` and use the `session()` helper to store/get information (e.g. flash sessions).

## Config

The lifetime and other options could be set as before in the `session` file.

The `VerifyHeaderCsrfToken` and `StartStatelessSession` middlewares will inject into headers the session key.

The session key name could be configured in the:

```php
stateless.header => env('STATELESS_HEADER', 'X-STATELESS-HEADER')
```

Danger: The key name separators should use `-` not `_` [according with this](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers).
### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email eduard.lupacescu@binarcode.com instead of using the issue tracker.

## Credits

- [Eduard Lupacescu](https://github.com/binarcode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
