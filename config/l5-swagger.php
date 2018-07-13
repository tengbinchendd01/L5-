<?php
/*
 *  for example project V1  you can update it
 *  copy it to laravel config cate
 */
return [
    'projects' => [
        'V1' => require_once(base_path('app') . '/V1/config/l5-swagger.php'),
    ],
    'views'    => base_path('resources/views/vendor/l5-swagger'),
];
