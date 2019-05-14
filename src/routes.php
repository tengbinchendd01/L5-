<?php

$router->get("/api/docs", [
    'as'         => "l5-swagger.api",
    'middleware' => config('l5-swagger.middleware.api', []),
    'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@api',
]);

$router->any("/docs" . '/{jsonFile?}', [
    'as'         => "l5-swagger.docs",
    'middleware' => config('l5-swagger.middleware.docs', []),
    'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@docs',
]);

$router->get("/docs" . '/asset/{asset}', [
    'as'         => "l5-swagger.asset",
    'middleware' => config('l5-swagger.middleware.asset', []),
    'uses'       => '\L5Swagger\Http\Controllers\SwaggerAssetController@index',
]);

$router->get("/api/oauth2-callback", [
    'as'         => "l5-swagger.oauth2_callback",
    'middleware' => config('l5-swagger.middleware.oauth2_callback',
        []),
    'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@oauth2Callback',
]);




