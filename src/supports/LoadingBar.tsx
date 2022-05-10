import React from "react";

type IlocalProps = {
    className?:string
}

type IlocalState = {

}

const LoadingBar=(props:IlocalProps)=><div className={props.className?props.className:'loadingBar'} /> 

export {LoadingBar}