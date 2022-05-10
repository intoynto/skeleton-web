<?php
declare (strict_types=1);

require_once __DIR__."/../app/helper.php";
require_once __DIR__ ."/../vendor/autoload.php";

use Intoy\HebatApp\Boot;
use Intoy\HebatFactory\AppFactory;
use App\Error\Renderer\HtmlErrorRenderer;

$app=Boot::createApp();
$kernel=$app->getKernel();

// global midleware mix
$kernel->middleware=[...$kernel->middleware,...[
    \App\Middleware\JWTApplyParamsMiddleware::class,
    \App\Middleware\CheckUserStaMiddleware::class,
    \App\Middleware\CookieMiddleware::class,
]];

// Web middleware mix
$kernel->middlewareGroups["web"]=[...$kernel->middlewareGroups["web"],...[
    \App\Middleware\TwigSessionMiddleware::class
]];

// mixed xall path
$kernel->middlewareGroups["xall"]=[...$kernel->middlewareGroups["web"]];


// register error render in kernel
$kernel->registerErrorRender("text/html",HtmlErrorRenderer::class);

// setup kernel
$kernel->setup();


$displayInfo=function()
{
    dd([
        //'session'=>session()->getOptions(),
        'path_base'=>path_base(),
        'path_app'=>path_app(),
        'path_config'=>path_config(),
        'path_routes'=>path_routes(),
        'path_view'=>path_view(),
        'path_public'=>path_public(),
        'path_assets'=>path_assets(),
        'url_base'=>url_base(),
        'basePath'=>AppFactory::$app->getBasePath(),
        'middeware'=>AppFactory::$app->resolve('middleware'),        
        //'entrys'=>AppFactory::$app->getContainer()->getKnownEntryNames(),
    ]);
};

//$displayInfo(); exit;
$app->run();