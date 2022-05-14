<?php
declare (strict_types=1);

namespace App;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\Modifier\SameSite;

class TokenJwt 
{
    const F_AUD='aud';
    const F_IIS="iis";
    const F_JTI='jti';
    const SECRET_KEY="hebat@skeleton-php";
    const SECRET_ALG='HS256';
    const SECRET_AUD="Hebat@corps";

    /**    
     * Merubah cookie harus build kembali js
     */
    
    const JWT_COOKIE="skeleton-php";

    public static function getCookieName()
    {
        return static::JWT_COOKIE;
    }

    public static function makeJWT(array $data, bool $useExpired=false)
    {
        $now = time();
        $expire = strtotime('+1 day',$now);
        
        $payload=$data;
        $payload[static::F_AUD]=static::SECRET_AUD;

        //expire
        if($useExpired)
        {
            $payload['iat']=$now; //stempel waktu penerbitan token
            $payload['nbf']=$now; // kapan token bisa digunakan. Setidaknya sama dengan iat
            $payload['exp']=$expire; // kapan masa token akan habis
        }

        $payload[static::F_JTI]=base64_encode(openssl_random_pseudo_bytes(32)); //unique token 
        return JWT::encode($payload,static::SECRET_KEY, static::SECRET_ALG);
    }


    public static function decode(string $jwt)
    {
        // old version
        //return JWT::decode($jwt,static::SECRET_KEY,[static::SECRET_ALG]);

        // new version
        return JWT::decode($jwt,new Key (static::SECRET_KEY,static::SECRET_ALG));
    }

    /**
     * @return SetCookie
     */
    public static function cookieCreate($value=null,$cookieName="")
    {
        if(!$cookieName)
        {
            $cookieName=static::getCookieName();
        }
        $cookie = SetCookie::create($cookieName, $value)
            ->withPath("/")
            ->withSameSite(SameSite::lax());
        return $cookie;
    }
}