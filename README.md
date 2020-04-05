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

To initiate the session you can use this middleware:

``` php
->middleware(\Binarcode\LaravelStatelessSession\Http\Middleware\StartStatelessSession::class)
```

To protect some routes with CSRF token just use this middleware:

``` php
->middleware([ 
\Binarcode\LaravelStatelessSession\Http\Middleware\StartStatelessSession::class,
\Binarcode\LaravelStatelessSession\Http\Middleware\VerifyHeaderCsrfToken::class, 
]) 
// this will return back a response header `XSRF-TOKEN`
```


Any GET request with `stateless.session` or `stateless.csrf` will return back a response header with key 
configured in `config('stateless.header')`.

This header should be sent back to the server with the same name, so the SessionManager could find the right session.

If the request should perform a csrf check, just add a `X-CSRF-TOKEN` with the value received in the previous request 
under `XSRF-TOKEN` header name.

## Config

The API will inject into headers the session key. The session key name could be configured in the:

```php
stateless.header => env('STATELESS_HEADER', 'X-STATELESS-HEADER')
```

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
