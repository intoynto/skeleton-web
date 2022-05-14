<?php
declare (strict_types=1);

namespace App\Middleware;

use App\Models\UserModel as User;

class AuthAdmin extends AuthBase
{
    protected function nextValidation($request)
    {
        $is_oke=$this->user_tipe===User::D_TIPE_ADMIN;
        if(!$is_oke)
        {
            $this->error=sprintf("Autorisasi hanya pengguna Administrator");
            return;
        }
    }
}