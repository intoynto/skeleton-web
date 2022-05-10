import Cookies from "js-cookie";
import { toStr } from "intoy-utils";
import JwtDecode from "intoy-jwtdec";
import {AC_SET_USER,Store} from "./Store";
import { isAuth } from "./auth";
import { jwt_cookie_name } from "./def";

type IjcookieProps = 
{

}

const defaultCookieProps:IjcookieProps = {
}


interface IJcookie {
    getToken:()=>string|undefined
    fetchTokenToStore:()=>void
    invalidate:(cb?:()=>void)=>void
}

class Jcookie implements IJcookie
{
    private cookie_name:string=jwt_cookie_name;

    private value_cookie:any;
    private ilogin:boolean=false;

    constructor(props?:IjcookieProps)
    {
        props=props||defaultCookieProps;
    }

    getToken=()=>{
        return Cookies.get(this.cookie_name);
    }

    fetchTokenToStore=()=>{
        const jwt = toStr(this.getToken());
        this.value_cookie=jwt;
        let user: any = null;
        if (jwt) {
            user = JwtDecode(jwt);
        }        
        Store.dispatch({ type: AC_SET_USER, payload: user });
        this.ilogin=isAuth();
    }

    invalidate=(cb?:()=>void)=>
    {
        const jwt = toStr(this.getToken());
        const last_ilogin=this.ilogin;
        if(this.value_cookie!==jwt)
        {
            this.fetchTokenToStore();            
        }

        if(last_ilogin && !this.ilogin)
        {
            console.warn("you must redirect to login");
            return;
        }

        typeof cb==="function"?cb():null;
    }
}


let localjCookie:IJcookie|null=null;


export function getJCookie():IJcookie
{
    if(!localjCookie)
    {
        localjCookie=new Jcookie();
    }

    return localjCookie;
}