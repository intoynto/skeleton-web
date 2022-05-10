import React from "react";
import {getUrlLogin} from "./def";

export default ()=>(
    <div className="relative h-full flex items-center justify-center">
        <div className="p-4 pb-10 text-center">
            <div className="text-8xl font-semibold">Crash</div>
            <div>You've sent a bad request</div>
            <div>You don't have a authentication. Go <a href={getUrlLogin()}>Login</a></div>
        </div>
    </div>
);