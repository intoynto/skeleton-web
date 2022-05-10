<?php
declare (strict_types=1);

namespace App;

use App\Models\User;
use App\Models\LogLoginModel as LogLogin;

class Auth 
{
    /**
     * @var User
     */
    protected static $user=null;

    /**
     * @var int $tahun
     */
    protected static $tahun=null;

    protected const passwordOptions=[
        'cost' => 10,
        'author'=>'hebat@corps',
        "app"=>"hebat-e-monep",
    ];

    /**
     * @param string $password
     * @return string
     */
    public static function makePassword(string $password):string
    {
        return password_hash($password,PASSWORD_DEFAULT,static::passwordOptions);
    }


    static function passwordVerify(string $old_password_un_hash, string $old_password_hash)
    {
        return password_verify($old_password_un_hash,$old_password_hash);
    }


    /**
     * @param string $username
     * @param string $password
     * @return User|bool 
     */
    public static function attempt($username,$password)
    {
        $username=trim((string)$username);
        $f_username=User::F_USERNAME;
        $f_password=User::F_PASSWORD;

        $mod=new User();
        [$table,$fields]=$mod->getTableOrView();

        $builder=User::connection()->query()->select($fields)->from($table)->where($f_username,'=',$username)->take(1);

        if(!$builder->exists()) 
        {
            return false;
        }
        
        $user=(object)$builder->get()->first();
        

        if(!static::passwordVerify((string)$password,(string)$user->$f_password))
        {
            return false;
        }

        return $user;
    }


    /**
     * @param string $id_user
     * @param string $jwt_key
     * @return User|bool
     */
    public static function userAttempJWT($id_user, $jwt_key)
    {
        $f_username=User::F_USERNAME;
        $f_password=User::F_PASSWORD;

        $mod=new User();
        [$table,$fields]=$mod->getTableOrView();

        $builder=User::connection()->query()->select($fields)->from($table)->where(compact('id_user', 'jwt_key'))->take(1);

        if(!$builder->exists()) 
        {
            return false;
        }

        $user=(object)$builder->get()->first();

        static::attempUser($user);
        return static::$user;
    }


    /**
     * @param User $user
     */
    public static function attempUser($user)
    {
        unset($user->upass); //remove password
        static::$user = $user;
    }

    /**
     * @param string|int|null $tahun
     */
    public static function attemptTahun($tahun)
    {
        static::$tahun=$tahun;
        if(!is_null($tahun))
        {
            session()->set("tahun",$tahun);
        }
        else {
            session()->remove("tahun");
        }
    }
    /**
     * @return int
     */
    public static function getTahun()
    {
        $ses_tahun=session()->get("tahun");
        return is_null(static::$tahun)?(!is_null($ses_tahun)?$ses_tahun:(int)date("Y")):static::$tahun;
    }

    public static function logout()
    {
        session()->remove("user");
        session()->destroy();
        static::$user=null;
    }


    public static function check() : bool
    {
        $true=isset(static::$user) && static::$user!==null && is_object(static::$user);
        return (bool)$true;
    }

    public static function guest() : bool
    {
        return !static::check();
    }

    /**
     * @return User|null
     */
    public static function getUser()
    {
        return static::check()?static::$user:null;
    }


    /**
     * Check equal user by attribute
     * @param string $attribute
     * @param mixed $current_value
     * @return bool
     */
    public static function isEqualUserAttribute(string $attribute, $test_value)
    {
        $true=false;
        $u=static::getUser();
        if($u)
        {
            $value=$u->$attribute;
            $true=$test_value===$value;
            if(!$true && is_numeric($test_value) && is_string($value))
            {
                $value=(int)$value;
                $true=$test_value===$value;
            }
        }

        return $true;
    }


    /**
     * untuk merekam user ke sistem
     * bahwa user sedang login
     * 
     * @param string|int $id_user
     * @param string $ip
     */
    public static function rekamUserLogin($id_user, $ip)
    {
        $f_id=User::F_ID;
        $last_login=date("Y-m-d H:i:s");

        // update user info
        User::where($f_id,"=",$id_user)->take(1)->update(compact("last_login"));

        // update log
        $tanggal=$last_login;
        $status_login=1;
        LogLogin::create(compact("id_user","ip","tanggal","status_login"));
    }


    /**
     * untuk merekam user ke sistem
     * bahwa user sudah logout
     * 
     * @param string|int $id_user
     * @param string $ip
     */
    public static function rekamUserLogout($id_user, $ip)
    {
        $f_id=User::F_ID;
        $last_login=date("Y-m-d H:i:s");
        User::where($f_id,"=",$id_user)->take(1)->update(compact("last_login"));

        // update log
        $tanggal=$last_login;
        $status_login=0;
        LogLogin::create(compact("id_user","ip","tanggal","status_login"));
    }
}