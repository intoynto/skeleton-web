import {legacy_createStore as createStore, combineReducers} from "redux";

const AC_START="AC:START";
export const AC_SET_USER="AC:SET_USER";
export const AC_SET_ONLINE_USERS="AC:SET_ONLINE_USERS";
export const AC_SET_OPEN_MENU="AC:SET_OPEN_MENU";

interface IState{
    type:String,
    payload:any,
}


function startReducer(state=null,{type,payload}:IState){
    switch(type){
        case AC_START:return payload;
        default :return state;
    }
}

function userReducer(state=null,{type,payload}:IState)
{
    switch(type){
        case AC_SET_USER:return typeof payload==="object" && !Array.isArray(payload)?{...payload}:null;
        default :return state;
    }
}

function openMenuReducer(state=false,{type,payload}:IState)
{
    switch(type){
        case AC_SET_OPEN_MENU:return payload===true || payload===false?payload:false;
        default :return state;
    }
}

function userOnlineReducer(state=[],{type,payload}:IState)
{
    switch(type)
    {
        case AC_SET_ONLINE_USERS:return Array.isArray(payload)?payload.slice(0):[];
        default :return state;
    }
}


const allReducer=combineReducers({
    _start:startReducer,
    user:userReducer,
    openMenu:openMenuReducer,
    userOnline:userOnlineReducer,
});

const Store=createStore(allReducer);

export type State=ReturnType<typeof allReducer>;

export {Store}