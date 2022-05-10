<?php

namespace App\Providers;

use Intoy\HebatFactory\Provider;
use App\Auth;
use App\TokenJwt;

class AuthProvider extends Provider
{
    protected function boot()
    {
        $fn=fn()=>(new Auth());
        app()->bind(Auth::class,$fn);
        app()->bind('auth',$fn); //alias
        // register cookie name for twig
        // dan twig akan membuat element di body yang menyertakan nama attribut cookie
        app()->bind('jwt-cookie',TokenJwt::getCookieName());
    } 
}