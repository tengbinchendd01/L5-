
L5 Swagger
==========

Swagger 2.0 for Laravel >=5.1

This package is a wrapper of [Swagger-php](https://github.com/zircote/swagger-php) and [swagger-ui](https://github.com/swagger-api/swagger-ui) adapted to work with Laravel 5.

Installation
============

You can publish L5-Swagger's config and view files into your project by running:

```bash
$ php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

For Laravel >=5.5, no need to manually add `L5SwaggerServiceProvider` into config. It uses package auto discovery feature. Skip this if you are on >=5.5, if not:

Open your `AppServiceProvider` (located in `app/Providers`) and add this line in `register` function
```php
$this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
```
or open your `config/app.php` and add this line in `providers` section
```php
L5Swagger\L5SwaggerServiceProvider::class,
```

## Swagger annotations and generating documentation
In order to generate the Swagger documentation for your API, Swagger offers a set of annotations to declare and manipulate the output. These annotations can be added in your controller, model or even a seperate file. An example of annotations can [be found here](https://github.com/DarkaOnLine/L5-Swagger/blob/master/tests/storage/annotations/Swagger/Anotations.php). For more info check out Swagger's ["pet store" example](https://github.com/zircote/swagger-php/tree/3.x/Examples/petstore-3.0) or the [Swagger OpenApi Specification](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md).

After the annotiations have been added you can run `php artisan l5-swagger:generate` to generate the documentation. Alternatively, you can set `L5_SWAGGER_GENERATE_ALWAYS` to `true` in your `.env` file so that your documentation will automatically be generated. Make sure your settings in `config/l5-swagger.php` are complete.

Using [OpenApi 3.0 Specification](https://github.com/OAI/OpenAPI-Specification)
============
If you would like to use lattes OpenApi specifications (originally known as the Swagger Specification) in you project you should:
- Explicitly require `swagger-php` version 3.* in your projects composer by running:
```bash
composer require 'zircote/swagger-php:3.*'
```
- Set environment variable `SWAGGER_VERSION` to **3.0** in your `.env` file:
```
SWAGGER_VERSION=3.0
```
or in your `config/l5-swagger.php`:
```php
'swagger_version' => env('SWAGGER_VERSION', '3.0'),
```
- Use examples provided here: https://github.com/zircote/swagger-php/tree/3.x/Examples/petstore-3.0


Using Swagger UI with Passport
============
The easiest way to build and test your Laravel-based API using Swagger-php is to use Passport's `CreateFreshApiToken` middleware. This middleware, built into Laravel's core, adds a cookie to all responses, and the cookie authenticates all subsequent requests through Passport's `TokenGuard`.

To get started, first publish L5-Swagger's config and view files into your own project:

```bash
$ php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

this is base my project  

```php
   app
     |-console
     |-Exceptions
     |-Helpers
     |-Jobs
     |-Middleware
     |-Providers
     |-V1
        |-config
        |-Formatters
        |-Http
        |-Models
        |-Repositories
        |-Services
     |-V2
        |-config
        |-Formatters
        |-Http
        |-Models
        |-Repositories
        |-Services      
          
```
app/middleware

create new file `Kernel.php`

```php
<?php

namespace App\Middleware ;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;

class Kernel extends HttpKernel
{
    protected $moduleKernel
        = [
            "\\App\\V1\\Http\\Kernel" ,
            "\\App\\V2\\Http\\Kernel"
        ];

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware
        = [
        ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups
        = [
            'web' => [
            ],

            'api' => [
                'throttle:60,1',
                'bindings',
            ],
        ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware
        = [
         ];

    public function __construct(Application $app, Router $router)
    {
        if (count($this->moduleKernel)) {
            foreach ($this->moduleKernel as $middle) {
                if (class_exists($middle)) {
                    $this->middleware       = array_merge($this->middleware,
                        $middle::$middleware);
                    $this->middlewareGroups = array_merge($this->middlewareGroups
                        , $middle::$middlewareGroups);
                    $this->routeMiddleware  = array_merge($this->routeMiddleware
                        , $middle::$routeMiddleware);
                }
            }
        }

        parent::__construct($app, $router);
    }
}

```

app\V1\config

create new `l5-swagger.php`  add  project version


```php
    'api' => '/v1/api/docs',
    'docs' => '/v1/docs',
    'oauth2_callback' => 'v1/api/oauth2-callback',
```


config\l5-swagger.php

```php
    'projects' => [
        'V1' => require_once(base_path('app') . '/V1/config/l5-swagger.php'),
        'V2' => require_once(base_path('app') . '/V2/config/l5-swagger.php'),
    ],
    'views'    => base_path('resources/views/vendor/l5-swagger'),
```