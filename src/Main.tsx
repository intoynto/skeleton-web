import React,{Suspense} from "react";
import {connect} from "react-redux";
import { Routes, Route } from "react-router";
import {withRouter,TWithRouterProps} from "./withRouter";

import { isAuth} from "./auth";
import { PATH } from "./consts";
import { State } from "./Store";

import Page404 from "./pages/p404";
import Page403 from "./pages/p403";
import NoAuth from "./NoAuth";

import { LoadingBar } from "./supports/LoadingBar";

import {
    Home,
} from "./lazy";

type IlocalProps = TWithRouterProps & {
    user:any
}

type IlocalState = {

}
type Iprops=IlocalProps;
type Istate=IlocalState;

class Comp<P extends Iprops,S extends Istate> extends React.Component<P,S>
{
    protected ndMain:HTMLElement | null | undefined = null;
    render()
    {
        const ilogin=isAuth();
        if(!ilogin)
        {
            return <NoAuth />            
        }   
        
        return (
            <main id="main" ref={fn => this.ndMain = fn}>
                <Suspense fallback={<LoadingBar />}>
                    <Routes>
                        <Route path={PATH.HOME} element={<Home />} />
                        <Route path={PATH.P400} element={<Page404 />} />
                        <Route path={PATH.P403} element={<Page403 />} />
                        <Route path="*" element={<Page404 />} />
                    </Routes>
                </Suspense>
            </main>
        );
    }
}

function mpToProps(state:State)
{
    return {
        user:state.user
    };
}

const Main=connect(mpToProps)(Comp);

export default withRouter(Main as any);