<?php

use App\TokenJwt;

return [
    /**
     * Application name
     */
    'name'=>'SkeletonPhp',

    /**
     * Application title
     */
    'instance'=>'HebatCorps',

    /**
     * Application title
     */
    'title'=>'SkeletonPhp - Hebat Corps',

    /**
	* decription
	*/
    'description'=>'Startup Boot PHP untuk web dan api', 

    /**
     * Application version
     */
    'version'=>'0.1',

    /**
     * Development Build
     * development | dev | production | prod
     */
    'env'=>'development',

    /**
     * Nama cookie untuk jwt yang akan di bind ke cookie browser
     */
    "jwt_cookie"=>TokenJwt::JWT_COOKIE,

    /**
     * Cors allow origin
     * Allow all set "*" value
     * Example app response :
     * Access-Control-Allow-Origin : "*"
     */
    "cors_origin"=>null,


    /**
     * Register Timezone
     */
    'timezone'=>'Asia/Makassar',    

    'providers'=>[
        \App\Providers\AuthProvider::class,
    ],
];