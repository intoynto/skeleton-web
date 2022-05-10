import React from "react";
import {connect} from "react-redux";
import {withRouter, TWithRouterProps, pathIsMatch} from "./withRouter";
import {State} from "./Store";
import {IR_User} from "./types";
import { confirmSignOut } from "./confirmSignOut";

type IlocalProps = {
    user:IR_User | null | undefined
}

type IlocalState = {

}

type Iprops=IlocalProps;
type Istate=IlocalState;

function mpToProps(state:State)
{
    return {
        user:state.user,
    }
}

class Comp<P extends Iprops,S extends Istate> extends React.Component<P,S>
{
    onClickSignOut=(e:React.MouseEvent)=>{
        if(e) e.preventDefault();
        confirmSignOut()
        .then();
    }
}

const CompConnect=connect(mpToProps)(Comp as any);

export default withRouter(CompConnect as any);