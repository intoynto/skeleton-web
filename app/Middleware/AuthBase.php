<?php
declare (strict_types=1);

namespace App\Middleware;

use App\Auth;
use App\Models\UserModel as User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Exception\HttpException;

class AuthBase 
{
    /**
     * @var string
     */
    protected string $error="";

    /**
     * @var int Http Error Code
     */
    protected int $codeError=401; //default 401 Unautorized

    /**
     * @var int|null
     */
    protected $user_tipe=null;


    protected function failed()
    {
        return !empty($this->error);
    }

    /**
     * @param Request $request
     */
    protected function nextValidation(Request $request)
    {

    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke($request, $handler)
    {        
        $user=Auth::getUser();
        if($user)
        {            
            $field=User::F_LEVEL;
            $tipe=trim((string)$user->$field);
            if(strlen($tipe)<1)
            {
                throw new HttpException($request,sprintf("Autorisasi tidak valid"),403);
            }

            $this->user_tipe=(int)$tipe;            
        }

        $this->nextValidation($request);       

        if($this->failed())
        {
            throw new HttpException($request,$this->error,$this->codeError); // un autorized
        }

        return $handler->handle($request);
    }
}