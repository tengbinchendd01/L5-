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
    public $project           = "V1";
    public $configPath        = "l5-swagger.";
    public $projectConfigPath = "l5-swagger.projects.";

    public function __construct()
    {
        $path    = Request::path();
        $pathArr = explode('/', $path);
        if (isset($pathArr[0])) {
            $this->project           = strtoupper($pathArr[0]);
            $this->projectConfigPath = $this->projectConfigPath . $this->project . '.';
        }
    }
}
