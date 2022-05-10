<?php

use App\TokenJwt;
use Intoy\HebatApp\JWTMiddleware\RequestMethodRule;
use Intoy\HebatApp\JWTMiddleware\RequestPathRule;

return [
    // array route groups
    // [key,path] 
    // key adalah key pada kernel middlewareGroups
    // path ada path group pada route group $app->group($path);
    // key juga akan di require pada folder Routing sesuai dengan key contoh : web.**.php;
    "prefix"=>[
        "web"=>"",
        "api"=>"/api",
        "xall"=>"", // aliasing after
    ],

    // Psr-4 untuk namespace request
    "request"=>"App\\Requests\\",

    // Psr-4 untuk namespace Controllers
    // Anda bisa menggunakan namespace berupa array, dengan catatan key array harus sesuai dengan key prefix
    // Contoh 
    // "controllers"=>[
    //     "web"=>"App\\WebControllers\\"
    //     "api"=>"App\\ApiControllers\\"
    //     "test"=>"App\\TestControllers\\"
    // ],

    // atau bisa juga menggunnakan array array  
    // "controllers"=>[
    //     "web"=>[
    //              "App\\WebControllers\\"
    //              "App\\Web2Controllers\\"
    //            ],
    //     "api"=>"App\\ApiControllers\\"
    //     "test"=>"App\\TestControllers\\"
    // ],    
    "controllers"=>"App\\Controllers\\", 
        
    // attribut yang akan diextract oleh middleware yang akan di bind ke parameter queryParams atau parseBody
    "jwt_apply_params"=>[
        "tahun",
        "kode_sub_organisasi"
    ],

    //  konfigurasi auth midleware JWTMiddleware

    'jwt'=>[
        'secret'=>TokenJwt::SECRET_KEY, // key secreen
        'algorithm'=>'HS256', // algoritm token JWT secret
        'leeway'=>60, // leeway time JWT
        'cookie'=>TokenJwt::JWT_COOKIE, //attribut di cookie

        /**
         * Path sebaiknya relative terhadap web sub folder
         * Contoh misalnya path perlu pengecekan authentikasi adalah path "api"
         * Dan folder web ada pada subfolder "my-app" maka path harus relative menjadi "my-app/api"
         * Jika web tidak berada pada sub-folder maka cukup "api" atau "/api"
         */       
        "rules"=>[
            // setup rule METHOD
            new RequestMethodRule([
                "ignore"=>["OPTIONS","GET"], // allow methods 
            ]),
            // setup secure path
            new RequestPathRule([
                "path"=>"api", // secure path
                "ignore"=>[
                    "api/ping", // not secure this path
                    "api/report", // not secure this path
                ]
            ]),
        ],
        //'path'=>'api', // secure path
        //"ignore"=>[
        //    "api/ping",
        //    "api/report",
        //],
    ],
];