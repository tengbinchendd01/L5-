<?php

namespace L5Swagger\Http\Controllers;

use File;
use Illuminate\Support\Facades\URL;
use Request;
use Response;
use L5Swagger\Generator;
use Illuminate\Routing\Controller as BaseController;

class BaseSwaggerController extends BaseController
{
    public $project           = "v1";
    public $configPath        = "l5-swagger.";

    public function __construct()
    {
        $path    = Request::path();
        $pathArr = explode('/', $path);
        if (isset($pathArr[0])) {
            $this->project           = $pathArr[0];
            $this->docsJson = $this->project .'-api-docs.json';
        }
    }
}
