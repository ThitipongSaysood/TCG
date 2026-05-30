<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Blade view files live in app/pages/ (domain views) and app/includes/
    | (partials). Both folders are scanned by the view finder.
    |
    */

    'paths' => [
        base_path('app/pages'),
        base_path('app/includes'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
