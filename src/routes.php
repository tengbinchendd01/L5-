<?php

if (!empty($projects) && is_array($projects)) {
    foreach ($projects as $p => $v) {
        $path = "l5-swagger.projects.{$p}.";
        $router->get(config($path .'routes.api'), [
            'as' => "l5-swagger.{$p}.api",
            'middleware' => config($path .'routes.middleware.api', []),
            'uses' => '\L5Swagger\Http\Controllers\SwaggerController@api',
        ]);

        $router->any(config($path .'routes.docs').'/{jsonFile?}', [
            'as' => "l5-swagger.{$p}.docs",
            'middleware' => config($path .'routes.middleware.docs', []),
            'uses' => '\L5Swagger\Http\Controllers\SwaggerController@docs',
        ]);

        $router->get(config($path .'routes.docs').'/asset/{asset}', [
            'as' => "l5-swagger.{$p}.asset",
            'middleware' => config($path .'routes.middleware.asset', []),
            'uses' => '\L5Swagger\Http\Controllers\SwaggerAssetController@index',
        ]);

        $router->get(config($path .'routes.oauth2_callback'), [
            'as' => "l5-swagger.{$p}.oauth2_callback",
            'middleware' => conl5-swagger.assetfig($path .'routes.middleware.oauth2_callback', []),
            'uses' => '\L5Swagger\Http\Controllers\SwaggerController@oauth2Callback',
        ]);

    }
}

