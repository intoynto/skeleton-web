<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

class TwigSessionMiddleware 
{
    public function __invoke(Request $request, Handler $handler):Response
    {
        $v=app()->resolve('view')->getEnvironment();    
        
         // add auth to twig view
        $auth=[
            "check"=>app()->resolve("auth")->check(),
            "user"=>app()->resolve("auth")->getUser(),
            "tahun"=>app()->resolve("auth")->getTahun(),
            // informasi bind nama cookie ke div twig
            'jwt_cookie'=>app()->has('jwt-cookie')?app()->resolve('jwt-cookie'):null,
        ];
        $v->addGlobal("auth",(object)$auth); 

        $flash=[
            'old'=>session()->flashGet("old"),
            'error'=>session()->flashGet("error"),
            'message'=>collect(session()->flashGet("message"))->first(),
            "info"=>session()->flashGet("info"),
        ];

        $v->addGlobal('flash',(object)$flash);    

        //clear flash
        session()->flashAll();//

        // next handle
        $response=$handler->handle($request); 
        
        return $response;  
    }
}