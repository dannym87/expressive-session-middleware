# expressive-session-middleware

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/dannym87/expressive-session-middleware.svg?branch=master)](https://travis-ci.org/dannym87/expressive-session-middleware)
[![Downloads](https://img.shields.io/packagist/dt/damess/expressive-session-middleware.svg)](https://packagist.org/packages/damess/expressive-session-middleware)

Simple session middleware for Zend Expressive

## Install

Via Composer

``` bash
$ composer require damess/expressive-session-middleware
```

## Usage

Add the following factories to your container config

``` php
return [
    'dependencies' => [
        'factories'  => [
            DaMess\Http\SessionMiddleware::class    => DaMess\Factory\SessionMiddlewareFactory::class,
            Aura\Session\Session::class             => DaMess\Factory\AuraSessionFactory::class,
        ],
    ],
];
```

Set up the pre-routing middleware. 

```php
return [
    'middleware_pipeline' => [
        'pre_routing' => [
            [
                'middleware' => DaMess\Http\SessionMiddleware::class,
            ]
        ],
        'post_routing' => [
            
        ],
    ],
];
```

Get the session object from the request

```php
/**
 * @param ServerRequestInterface $request
 * @param ResponseInterface $response
 * @return ResponseInterface
 */
public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
{
    /**
     * @var \Aura\Session\Session $session
     */
    $session = $request->getAttribute('session');
}
```

## Configuration

The session can be configured by adding the following data to your configuration i.e. session.global.php. See [session.global.php.dist](config/session.global.php.dist)

```php
return [
    'session' => [
        'name'     => 'PHPSESSID',
        'lifetime' => 7200,
        'path'     => null,
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ],
];
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
