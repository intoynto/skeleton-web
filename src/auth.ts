import {toInt,toStr} from "intoy-utils";
import {Store} from "./Store";

export const TIPE_USER_GUEST=0;
export const TIPE_USER_ADMIN=1;
export const TIPE_USER_USER=2;

export const FIELD_USER_ID="id_user";
export const FIELD_USER_NAMA="nama";
export const FIELD_USER_LEVEL="tipe";

export function getTipeUser(value_tipe_or_level:string | number){
    let val:number=typeof value_tipe_or_level==="string"?parseInt(value_tipe_or_level):typeof value_tipe_or_level==="number"?value_tipe_or_level:0;
    switch (val){
        case TIPE_USER_ADMIN:return "Administrator";
        case TIPE_USER_USER:return "User";
        default : return "Guest";
    }
}

export function getStoreUser(){
    return Store.getState().user;
}

function isAuthFrom(user:any){
    user=user||{};
    let hasil=true 
        && toStr(user[FIELD_USER_ID]).toString().trim().length>0
        && toStr(user[FIELD_USER_LEVEL]).toString().trim().length>0
        ;
    return hasil;
}

export function isAuth(){
    const user=getStoreUser()||{};    
    return isAuthFrom(user);
}

export function userIsAdmin(){
    const user=getStoreUser()||{};    
    const tipe=toInt(user[FIELD_USER_LEVEL]);
    const satu=isAuthFrom(user);
    const dua=tipe===TIPE_USER_ADMIN;
    return satu && dua;
}

export function userIsUser(){
    const user=getStoreUser()||{};    
    const tipe=toInt(user[FIELD_USER_LEVEL]);
    const satu=isAuthFrom(user);
    const dua=tipe===TIPE_USER_USER;
    return satu && dua;
}