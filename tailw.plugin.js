const plugin = require('tailwindcss/plugin');
const tinyColor=require("tinycolor2");
const devMode = process.env.NODE_ENV !== "production";

function hex2rgb(colorHex)
{
    const rgb=tinyColor(colorHex).toRgb();
    const {r,g,b}=rgb;
    return `${r},${g},${b}`;
}

const exposeCssVar=plugin.withOptions(function({
    colors="" // "blue" or "green" || ["blue","green"]
}={}){
    return function({addBase,theme})
    {
        function extractColorVars(colorObj,colorGroup)
        {
            if(!colorObj || !colorGroup) return null;

            if(typeof colorObj==="object" && Object.keys(colorObj).length>0)
            {
                Object.keys(colorObj).forEach(function(prop,index)
                {
                    const root={
                        [`--${colorGroup}-${prop}`]:hex2rgb(colorObj[prop]),
                    };
                    if(devMode)
                    {
                        root[`--${colorGroup}-${prop}-h`]=colorObj[prop];
                    }
                    addBase({
                        ':root':root
                    })
                });
            }
        }
        
        const mapColors=typeof colors==="string"?[colors]:colors;
        mapColors.forEach(function(group){
            extractColorVars(theme(`colors.${group}`),group);
        });
    }
});

module.exports={
    exposeCssVar
}