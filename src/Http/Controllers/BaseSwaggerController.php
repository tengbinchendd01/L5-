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
    public function __construct()
    {
    }
}
