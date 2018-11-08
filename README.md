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
add env config run project or version  can be generate docs
``````
APP_RUN_VERSION=V1,V2
``````
===========
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
访问地址 默认
```
http://xx.com/{v1}/api/docs
http://xx.com/{v1}/docs?{v1}-api-docs.json

```
