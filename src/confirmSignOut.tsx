import React from "react";
import { BaseModal, createModalPromise, IBaseModalProps, IBaseModalState } from "intoy-base";
import { IStrNoValue } from "./types";

const href_signout="auth/sign-out";

type IlocalProps = {}
type IlocalState = {}
type Iprops=IBaseModalProps & IlocalProps;
type Istate=IBaseModalState & IlocalState;

class Form<P extends Iprops,S extends Istate> extends BaseModal<P,S>
{
    constructor(props:P)
    {
        super(props);
        this.styleForm={
            maxWidth:'420px',
        }
    }

    rdrTitle():any
    {           
        const {loading}=this.state;
        return (
            <div className="windowTitle">                 
                <div className="auto">
                   Sign-Out
                </div>
                <div>
                    {!loading && <a className="close" onClick={this.props.onClose}>&#x2716;</a>}
                </div>
            </div>
        );        
    }

    rdrContent()
    {        
        return (
            <div className="windowContent">
                Apakah Anda akan keluar dari aplikasi?
            </div>
        )
    }    


    private doSignOut=()=>{
        this.setState({loading:true},()=>{
            typeof this.props.onClose==='function'?this.props.onClose():null;
        });
    }


    rdrActions():React.ReactNode | null | undefined
    {
        const {loading}=this.state;  
        
        return (
            <div className="windowAction">
                {loading && <button type="button" className={"btn"}>Mengirim... <i className="fa fa-spin fa-spinner"/></button>}
                {!loading && <a type="button" className={"btn btn-outline-primary"} href={href_signout} onClick={this.doSignOut}><i className="fa fa-thumbs-o-up" /> Iya Keluar</a>}
                {!loading && <a type="button" className={"btn btn-outline-danger"} onClick={this.props.onClose} ><i className="fa fa-remove" /> {this.btnCancelText}</a>}
            </div>
        )
    }
}

const confirmSignOut=(props?:any)=>createModalPromise({
    component:Form,
    url_insert:IStrNoValue,
    url_update:IStrNoValue,
    fieldid:IStrNoValue,
});

export {confirmSignOut}