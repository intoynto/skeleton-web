import React from "react";
import {Provider} from "react-redux";
import {BrowserRouter} from "react-router-dom";
import {getBaseName} from "intoy-utils";
import {Store} from "./Store";

import Header from "./Header";
import Main from "./Main";

export default ()=>{
    let loca=getBaseName();
    return (
        <Provider store={Store}>
            <BrowserRouter basename={loca}>
                <Header />
                <Main />
            </BrowserRouter>
        </Provider>
    );
};