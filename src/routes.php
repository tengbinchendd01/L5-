<?php
$runVersion = config("app.run_version");
$runArr     = explode(',', $runVersion);
if (count($runArr)) {
    foreach ($runArr as $p) {
        $p = strtolower($p);
        $router->get("/{$p}/api/docs", [
            'as'         => "l5-swagger.{$p}.api",
            'middleware' => config('l5-swagger.middleware.api', []),
            'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@api',
        ]);

        $router->any("/{$p}/docs" .'/{jsonFile?}', [
            'as'         => "l5-swagger.{$p}.docs",
            'middleware' => config('l5-swagger.middleware.docs', []),
            'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@docs',
        ]);

        $router->get("/{$p}/docs" . '/asset/{asset}', [
            'as'         => "l5-swagger.{$p}.asset",
            'middleware' => config('l5-swagger.middleware.asset', []),
            'uses'       => '\L5Swagger\Http\Controllers\SwaggerAssetController@index',
        ]);

        $router->get("/{$p}/api/oauth2-callback", [
            'as'         => "l5-swagger.{$p}.oauth2_callback",
            'middleware' => config('l5-swagger.middleware.oauth2_callback',
                []),
            'uses'       => '\L5Swagger\Http\Controllers\SwaggerController@oauth2Callback',
        ]);

    }
}


