<?php

return [
    // path template twig
    'path'=>path_view(),

    // twig configuration
    'twig'=>[
        'debug' => !is_production(),
        'charset' => 'UTF-8',
        'strict_variables' => false,
        'autoescape' => 'html',
        'cache' => is_production()?path_base("_cache/twig"):false,
        'auto_reload' => null,
    ],
];