import React from "react";
import ReactDOM from "react-dom";
import {Select} from "intoy-select";


type IcomProps = {

}

type IcomState = {
    value:any
}

class CompSelect<P extends IcomProps,S extends IcomState> extends React.Component<P,S>
{    
    constructor(props:P)
    {
        super(props);
        this.state={
            value:''
        } as S;
    }

    private onCh=(e:any)=>
    {
        this.setState({value:e.target.value});
    }

    render()
    {
        const options = [
            { value: "75", label: "Provinsi" },
            { value: "75.71", label: "Kota Gorontalo" },
            { value: "75.01", label: "Kabupaten Gorontalo" },
            { value: "75.02", label: "Kabupaten Boalemo" },
            { value: "75.03", label: "Kabupaten Bone Bolango" },
            { value: "75.04", label: "Kabupaten Pohuwato" },
            { value: "75.05", label: "Kabupaten Gorontalo Utara" },
        ];
        return (
            <Select fieldid="value" fieldname="value" name="value" value={this.state.value} options={options} onChange={this.onCh} />
        );
    }
}

function renderChosens()
{
    const div=document.body.querySelectorAll('.render-chosen');
    
    for(let i=0; i<div.length; i++)
    {
        ReactDOM.render(<CompSelect />,div[i]);
    }
}

renderChosens();

console.log("Im Web Home");