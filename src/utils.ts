type IathFormProps = {
    selector?:string
    cb?:()=>void
}

export function attachFormJs(props:IathFormProps)
{
    const doCall=function(){
        typeof props.cb==='function'?props.cb():null;
    };
    const selector=props.selector||'.form-js';
    const div=document.querySelector(selector);
    if(!div)
    {
        doCall();
        return;
    }

    const form:HTMLFormElement=div as HTMLFormElement;
    form.addEventListener("submit",function(evt:Event)
    {
        form.classList.add("base");
        form.classList.add("loading");
    });

    doCall();
}

export function removePreload(cb?:()=>void)
{
    const callCb=function(){
        typeof cb==='function'?cb():null;
    };

    const preload=document.querySelector("#page-preload");
    if(!preload){
        callCb();
        return;
    }

    preload.classList.add('fadeOut');
    setTimeout(function(){
        preload.parentNode?.removeChild(preload);
        callCb();
    },500);
}