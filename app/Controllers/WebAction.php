<?php
declare (strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dflydev\FigCookies\FigRequestCookies as FigRequest;
use Dflydev\FigCookies\FigResponseCookies as FigResponse;
use Intoy\HebatApp\Controllers\Controller;

use App\Auth;
use App\TokenJwt;

final class WebAction extends Controller
{
    public function home(Request $request, Response $response):Response
    {
        $template=Auth::check()?"api.twig":"web.twig";
        $template="api.twig";
        return $this->view($response,$template);
    }

    public function allRoutes(Request $request, Response $response):Response
    {
        $isAuth = Auth::check();
        if (!$isAuth) {
            $jwtCookieName = TokenJwt::getCookieName();
            $cookie = FigRequest::get($request, $jwtCookieName);
            $jwt = $cookie->getValue();
            if ($jwt) {
                // create cookie expire
                $cookie=TokenJwt::cookieCreate();
                $cookie->expire(); //set expire

                /// create redirect response
                $response = redirectFor('auth.sign.in');
                // bind cookie response
                $response=FigResponse::set($response,$cookie);

                // return response with cookie expire
                return $response;
            }
            
            // send back json not found
            throw new \Slim\Exception\HttpNotFoundException($request);
        }

        $template = 'api.twig';

        $response->getBody()->write($this->view->fetch($template, $this->data));
        return $response;
    }
}