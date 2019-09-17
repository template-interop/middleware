# template-interop/middleware

PSR-15 middleware to build a view for a response thanks to any template engine.

Compatible engines:

- Twig
- Latte
- Mustache
- Smarty
- Plates
- Blade
- Dwoo
- Div
- Foil
- Stamp

## Requirements

* PHP >= 7.0
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [template-interop/middleware](https://packagist.org/packages/template-interop/middleware).

```sh
composer require template-interop/middleware
```

## Usage

```php
$dispatcher = new Dispatcher([
    new TemplateEngine($twig, $streamFactory),
    new Router([
        'GET /hello/{name}' => function(ServerRequestInterface $request) {
            return (new Response(200))
                ->withAttribute('template-name', 'hello')
                ->withAttribute('template-parameters', ['name' => $request->getAttribute('name')])
            ;        
        }   
    ])
]);
$response = $dispatcher->dispatch(new ServerRequest);
```

Request attributes names are configurable:

```php
<?php

use Interop\Template\Middleware\TemplateEngine;
use Psr\Http\Message\ServerRequestInterface;

new TemplateEngine($twig, $streamFactory, 'tpl_name', 'tpl_params');
```
Contains the following options to configure the [json_decode](http://php.net/manual/en/function.json-decode.php) function:
