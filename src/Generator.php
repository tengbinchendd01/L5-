<?php

namespace L5Swagger;

use File;
use Config;

class Generator
{
    public static function generateDocs($project)
    {
        $runVersion = config("app.run_version");
        $runArr     = explode(',', $runVersion);
        if (count($runArr) < 1 || !in_array($project, $runArr)) {
            throw new \Exception("no run project");
        }
        $docsJson      = "{$project}-api-docs.json";

        $appDir  = config('l5-swagger.paths.annotations');
        $docDir  = config('l5-swagger.paths.docs');
        $docFile = $docDir . '/' . $docsJson;

        if (File::exists($docDir)) {
            // delete all existing documentation
            if (File::exists($docFile)) {
                File::delete($docFile);
            }
        } else {

            File::makeDirectory($docDir);
        }

        if (is_writable($docDir)) {
            self::defineConstants(config('l5-swagger.constants') ?: []);


            $excludeDirs = config('l5-swagger.paths.excludes');
            $swagger     = \Swagger\scan($appDir . '/' . $project
                , ['exclude' => $excludeDirs]);

            if (config('l5-swagger.paths.base') !== null) {
                $swagger->basePath = config('l5-swagger.paths.base');
            }

            $swagger->saveAs($docFile);

            $security = new SecurityDefinitions();
            $security->generate($docFile);
        }

    }

    protected static function defineConstants(array $constants)
    {
        if (!empty($constants)) {
            foreach ($constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }
    }
}
