import React from "react";
import ReactDOM from "react-dom";
import { removePreload } from "./utils";
import {setDefaultBaseModalTitleInsert, setDefaultBaseModalTitleUpdate} from "intoy-base";
import { getJCookie } from "./jcookie";
import App from "./App";

const jc = getJCookie();

function subscribe(cb?:()=>void)
{
    const XHR=XMLHttpRequest.prototype;
    let open=XHR.open;
    let send=XHR.send;
    XHR.open=function(method:string,url:string,...args:any[]){
        const self:any=this;
        return (open.apply as any)(self,[method,url,...args]);
    };
    XHR.send=function(body?: XMLHttpRequestBodyInit | null)
    {
        const self:any=this;
        this.addEventListener("load",function(){
            jc.invalidate();
        });
        (send.apply as any)(self,[body]);
    }

    typeof cb==='function'?cb():null;
}

function setupDefault(cb?:()=>void)
{
    setDefaultBaseModalTitleInsert("Entri");
    setDefaultBaseModalTitleUpdate("Ubah");
    typeof cb==='function'?cb():null;
}


function render()
{
    const div=document.getElementById("root");
    if(!div) return;
    ReactDOM.render(<App />,div,removePreload);
}

subscribe(function(){
    setupDefault(function () {
        jc.fetchTokenToStore();
        jc.invalidate(render);
    });
});

