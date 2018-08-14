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
        $filePath = config($this->configPath . 'paths.docs').'/'.
            (! is_null($jsonFile) ? $jsonFile : config($this->projectConfigPath . 'routes.docs_json'));

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
        if (config($this->configPath . 'generate_always')) {
            Generator::generateDocs();
        }

        if (config($this->configPath . 'proxy')) {
            $proxy = Request::server('REMOTE_ADDR');
            Request::setTrustedProxies([$proxy]);
        }

        // Need the / at the end to avoid CORS errors on Homestead systems.
        $response = Response::make(
            view('l5-swagger::index', [
                'project'            => $this->project ,
                'secure'             => Request::secure(),
                'urlToDocs'          => route("l5-swagger.{$this->project}.docs",
                    config($this->projectConfigPath .'routes.docs_json', 'api-docs.json')),
                'operationsSorter'   => config($this->configPath . 'operations_sort'),
                'configUrl'          => config($this->configPath . 'additional_config_url'),
                'validatorUrl'       => config($this->configPath . 'validator_url'),
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
