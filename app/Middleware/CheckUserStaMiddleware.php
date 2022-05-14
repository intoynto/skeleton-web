<?php
declare (strict_types=1);

namespace App\Middleware;

use Intoy\HebatFactory\Request;
use Intoy\HebatFactory\Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseFactoryInterface as Factory;

use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\Modifier\SameSite;
use Dflydev\FigCookies\FigResponseCookies;

use App\Auth;
use App\Models\UserModel as User;
use App\TokenJwt;


class CheckUserStaMiddleware 
{
    protected function getFactory():Factory
    {
        return app()->resolve(Factory::class);
    }

    protected function shouldOutUser(int $code=403, array $data=[]):Response
    {
        $factory=$this->getFactory();
        $response=$factory->createResponse($code);
        $response->getBody()->write(json_encode($data));

        ///clear jwt
        $jwtCookieName=TokenJwt::getCookieName();
        $cookie=SetCookie::create($jwtCookieName)
                   ->withValue(null)
                   ->withSameSite(SameSite::lax())
                   ->withPath("/")
                   ;
        $response=FigResponseCookies::set($response,$cookie);
        return $response->withHeader("content-type","application/json");
    }

    public function __invoke(Request $request, Handler $handler):Response
    {
        if(Auth::check())
        {
            $user=Auth::getUser();
            $field_tipe=User::F_LEVEL;
            $tipe=(int)$user->$field_tipe;
            if($tipe!==User::D_TIPE_ADMIN && false===Auth::isEqualUserAttribute("status_konfirmasi",1))
            {
                $data=[
                    "message"=>sprintf("Akses menunggu konfirmasi")
                ];
                $response=$this->shouldOutUser(403,$data);                
                return $response;
            }            
        }

        return $handler->handle($request);
    }
}