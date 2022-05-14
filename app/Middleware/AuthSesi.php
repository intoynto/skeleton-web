<?php
declare (strict_types=1);

namespace App\Middleware;

use App\Auth;
use App\Models\UserModel as User;
use App\Models\SesiModel as Sesi;

class AuthSesi extends AuthBase
{
    protected function nextValidation($request)
    {
        $iadmin=$this->user_tipe===User::D_TIPE_ADMIN;
        if(!$iadmin)
        {
            $params=Auth::getUser();
            $kode_organisasi=data_get($params,"kode_organisasi");
            $tahun=Auth::getTahun();
            if(empty($kode_organisasi) || empty($tahun))
            {
                $this->error=sprintf("Attribut pengguna tidak valid. Sertakan Kode Organisasi dan Tahun");
                return;
            }
            // check apakah ada sesi org
            $mod=new Sesi();
            [$table,$fields]=$mod->getTableOrView();
            $r=Sesi::connection()->query()->select($fields)->from($table)->where(compact("kode_organisasi","tahun"))->take(1)->first();
            if(!$r)
            {
                $this->error=sprintf("Pengguna dengan kode organisasi %s tidak memiliki sesi data",$kode_organisasi);
                return;
            }

            $buka=(int)data_get($r,"buka");
            if($buka<1)
            {
                $this->error=sprintf("Organisasi %s :: %s, sesi tahun data %s tidak dalam mode terbuka",$kode_organisasi,$r->organisasi,$tahun);
                return;
            }
            return;
        }
    }
}