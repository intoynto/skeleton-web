<?php
declare (strict_types=1);

namespace App\Middleware;

use App\Models\UserModel as User;

class AuthUser extends AuthBase
{
    protected function nextValidation($request)
    {
        $iadmin=$this->user_tipe===User::D_TIPE_ADMIN;
        $iuser=in_array($this->user_tipe,[User::D_TIPE_USER]);
        $is_oke=$iadmin || $iuser;
        if(!$is_oke)
        {
            $this->error=sprintf("Autorisasi hanya untuk pengguna dengan level user");
            return;
        }
    }
}