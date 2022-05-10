import React from "react";
import {Location} from "history";
import {NavigateFunction} from "react-router";
import { useNavigate, useLocation, useParams, useResolvedPath } from "react-router-dom";

export function pathIsMatch(location:Location|string,currentPath:string|string[]):boolean
{
    let isActive=false;
    const caseSensitive=false;
    const end=false;

    let pathname:string=(typeof location==='object'?location.pathname:location).toString().toLowerCase();

    const checkPath=(value:string)=>
    {
        value=value.toString().toLowerCase().trim();
        return (value===pathname) ||
              (!end && pathname.startsWith(value) && pathname.charAt(value.length)==="/");
    }

    if(typeof currentPath==='string')
    {
        isActive=checkPath(currentPath);
    }
    else 
    {
        for(let i=0; i<currentPath.length; i++)
        {
            isActive=checkPath(currentPath[i]);
            if(isActive) break;
        }
    }

    return isActive;
}

export type TWithRouterProps = {
    history:NavigateFunction
    location:Location
    match:any
    params:any
}

export const withRouter=(Component:any)=>{
    const Wrapper=(props:any)=>{
        const history=useNavigate();
        const location=useLocation();
        const params=useParams();
        const match={params}
        return (
            <Component history={history} location={location} match={match} params={params} {...props} />
        );
    }

    return Wrapper;
}