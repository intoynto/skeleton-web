<?php
namespace App\Middleware;

use Intoy\HebatSupport\Arr;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;
use App\Auth;

class JWTApplyParamsMiddleware 
{
    protected function withParams(Request $request):Request
    {
        $method=strtolower((string)$request->getMethod());
        $isPost=$method==="post";

        $parsed=$isPost?$request->getParsedBody():$request->getQueryParams();
        $params=$parsed??[];       

        $attrbutes=config("routes.jwt_apply_params");
        if(is_array($attrbutes) && count($attrbutes)>0)
        {
            $attributeValues=[];
            foreach(array_values($attrbutes) as $f)
            {
                $attributeValues[$f]=$request->getAttribute($f);
            }
            
            foreach(array_values($attrbutes) as $f)
            {
                $value=$request->getAttribute($f);
                if(empty($value) && $f==="tahun")
                {
                    $value=Auth::getTahun();
                }

                $request=$request->withAttribute($f,$value);

                if(!empty($value))
                {                    
                    if(!Arr::exists($params,$f) || strlen(trim((string)$params[$f]))<1)
                    $params[$f]=$value;
                }
            }
        }

        
        $request=$isPost?$request->withParsedBody($params):$request->withQueryParams($params);
        return $request;
    }

    public function __invoke(Request $request, Handler $handler):Response
    {
        $request=$this->withParams($request);
        return $handler->handle($request);
    }
}