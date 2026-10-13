<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    | These are the paths where Blade templates are stored. You can add
    | additional paths here for your application's views. By default,
    | Laravel looks in `resources/views`.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    | This option determines where all the compiled Blade templates will be
    | stored for your application. By default, this is `storage/framework/views`.
    |
    */

    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/cache/views'))),

];