import { getBaseHref, rTrim } from "intoy-utils";

 /**
 * Merubah cookie harus build kembali js
 * Contoh penulisan untuk wilayah provinsi : hebat-monep-75-4465
 */
export const jwt_cookie_name=`skeleto-php`;

export function getUrlLogin()
{
    let bsh=getBaseHref()||'';
    bsh=rTrim(bsh,'/');
    return `${bsh}/auth`;
}