<?php

namespace L5Swagger\Http\Controllers;

use File;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Request;
use Response;
use L5Swagger\Generator;

class SwaggerController extends BaseSwaggerController
{
    /**
     * Dump api-docs.json content endpoint.
     *
     * @param string $jsonFile
     *
     * @return \Response
     */
    public function docs($jsonFile = null)
    {
        if (empty($jsonFile)){
            return Response::make("", 200, [
                'Content-Type' => 'application/json',
            ]);
        }
        $filePath = config('l5-swagger.paths.docs').'/'.$jsonFile;

        if (! File::exists($filePath)) {
            abort(404, 'Cannot find '.$filePath);
        }

        $content = File::get($filePath);

        return Response::make($content, 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Display Swagger API page.
     *
     * @return \Response
     */
    public function api()
    {
        $json = Request::input("file" , "");
        $response = Response::make(
            view('l5-swagger::index', [
                'secure'             => Request::secure(),
                'urlToDocs'          => route("l5-swagger.docs", $json),
                'operationsSorter'   => config('l5-swagger.operations_sort'),
                'configUrl'          => config('l5-swagger.additional_config_url'),
                'validatorUrl'       => config('l5-swagger.validator_url'),
            ]),
            200
        );

        return $response;
    }

    /*
     * Display Oauth2 callback pages
     * @return string
     */
    public function oauth2Callback()
    {
        return \File::get(swagger_ui_dist_path('oauth2-redirect.html'));
    }
}
