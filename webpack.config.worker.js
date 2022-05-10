const path=require("path");
const webpack=require("webpack");
const TerserWebpackPlugin=require("terser-webpack-plugin");

module.exports=(env,args)=>
{
    const isProd=args && args.mode && args.mode==="production"?true:false;
    const mode=isProd?"production":"development";

    const entry={
        "worker1":"./src/workers/worker1.ts",
        "worker2":"./src/workers/worker2.ts",
    };

    const conf={
        target:"webworker",
        mode:mode,       
        entry:entry,        
        output:{
            path:`${path.join(__dirname,'public','assets')}`,
            filename:`workers/[name].js`,            
            chunkFilename: `workers/[name].[chunkhash:8].js`,
            chunkLoadingGlobal:'m3'     
        },
        resolve:{
            extensions: ['.ts', '.tsx', '.js'],
            alias: {
                "react": "preact/compat",
                "react-dom": "preact/compat",
                "react-dom/test-utils": "preact/test-utils",
                "react/jsx-runtime": "preact/jsx-runtime",
            },
            fallback: {
                "stream": false,
                "buffer": false,
                "crypto": false,
            }
        },
        module:{
            rules:[
                
            ],
        },
        plugins:[ 
              
        ],
        optimization:{
            minimize:isProd?true:false,
            minimizer:[],
        },       
    };


    //push worker loader
    //semua file yang mengandung kata worker menggunakan workder-loader
    conf.module.rules.push({
        //test: /\.worker\.ts$/,
        test: /\.(ts|js)$/,
        exclude: /node_modules/,
        use: [                      
            { 
                loader: 'babel-loader', 
                options:{
                    presets: [
                        "@babel/preset-env",
                        "@babel/preset-typescript",
                    ]
                }                
            },
        ],
    });

    if(isProd)
    {
        //remove comment        
        conf.optimization.minimizer.push(
            new TerserWebpackPlugin({    
                terserOptions:{
                    format:{
                        comments:false,
                    }
                },            
                extractComments:false,                
            })
        );        
    }

    return conf;
}