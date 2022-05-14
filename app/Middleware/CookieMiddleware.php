<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\Modifier\SameSite;
use Dflydev\FigCookies\SetCookie;

use App\Auth;
use App\TokenJwt;

class CookieMiddleware 
{

    public function __invoke(Request $request, Handler $handler):Response
    {
        
        $jwtCookieName=TokenJwt::getCookieName();
        
        $cookie=FigRequestCookies::get($request, $jwtCookieName);
        $jwt=$cookie->getValue();
        $is_auth=false;

        if($jwt)
        {
            // try decode token
            $user = null;
            try {
                $user = TokenJwt::decode((string)$jwt);
                $a_tahun=$user->tahun;
                if(Auth::userAttempJWT($user->id_user,$user->jwt_key))
                {
                    $user=Auth::getUser();
                    $is_auth=true;
                    $request = $request->withAttribute('user', $user);
                    $tahun=!empty($a_tahun)?$a_tahun:date("Y");
                    Auth::attemptTahun($tahun); //apply to auth
                    $request = $request->withAttribute("tahun",$tahun);
                    
                    $attributes=config("routes.jwt_apply_params");
                    if(is_array($attributes) && count($attributes)>0)
                    {
                        foreach(array_values($attributes) as $f)
                        {
                            if(isset($user->$f) && !empty($user->$f))
                            {
                                $request = $request->withAttribute($f,$user->$f);
                            }
                        }                        
                    }
                }
            } 
            catch (\Exception $e) 
            {
            }        
        }   

        $response=$handler->handle($request);

        $isRequestCookie=!empty($jwt) && $jwt!==null;
        $cookie=FigResponseCookies::get($response,$jwtCookieName);
        $jwt=$cookie->getValue();

        $isResponseCookie=!empty($jwt) && $jwt!==null;
        
        if((!$is_auth && $isRequestCookie) && (!$isResponseCookie))
        {
            //set expire cookie
            $cookie=TokenJwt::cookieCreate();
            $cookie->expire();               
            $response=FigResponseCookies::set($response,$cookie);
        }

        return $response;
    }
}