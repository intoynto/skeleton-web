const path=require("path");
const WebpackAssetsManifest = require('webpack-assets-manifest');
const CssExtractPlugin = require('mini-css-extract-plugin');
const CssMinify = require('css-minimizer-webpack-plugin');
const TerserWebpackPlugin=require("terser-webpack-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const devName=`skeleton-php-0.1`;
const glob=require("glob");
const usource=require("./wp.source");
const clean=require("./wp.clean");

module.exports=function(env,args)
{
    const isProd=args && args.mode && args.mode==="production"?true:false;
    const mode=isProd?"production":"development";

    const fileMerge=usource.toScanDir(glob.sync("./src/*"));
    const entry={
        'preload':'./src/_css/preload.scss',
        'style.main':'./src/_css/main.scss',
        'style.utils':'./src/_css/utils.scss',
        'utils':'./src/utils.ts',
        "consts":"./src/consts.ts",
        "api":"./src/api.tsx",
        ...fileMerge.merge,
    };

    console.log(fileMerge.merge);

    // clean file before
    clean.doRemove("js");
    clean.doRemove("json");

    const conf={
        target:'web',
        mode:mode,
        entry:entry,
        output:{
            path:path.join(__dirname,"public","assets"),
            filename:`js/${devName}.[name].js`,            
            chunkFilename: `js/${devName}.[name].[chunkhash:8].js`,
            chunkLoadingGlobal:'m3'
        },
        resolve:{
            extensions: ['.ts', '.tsx','.js'],
            alias: {
                "react": "preact/compat",
                "react-dom": "preact/compat",
                "react-dom/test-utils": "preact/test-utils",
                "react/jsx-runtime": "preact/jsx-runtime",             
            },        
            fallback:{
                "stream":false,
                "buffer":false,
                "crypto": false,
            }
        },
        plugins:[
            new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: [
                    'js',
                    'css',
                    'main.*.(js|json)',
                    'const.*.(js|json)',
                    'manifest.json',
                    '!workers/**'
                ],
            }),
            new CssExtractPlugin({
                filename: `css/${devName}.[name].css`,
            }),
            new WebpackAssetsManifest({
                //publicPath:isProd?`assets/`:`http://10.5.51.254:8080/`,
                publicPath:isProd?`assets/`:`http://localhost:8080/`,
                writeToDisk:true,
                output:'manifest.json',
            }),  
        ],
        module:{
            rules:[],
        },
        optimization:{
            minimize:isProd?true:false,
            minimizer:[],
        },
    };


    //compile s[ac]ss
    conf.module.rules.push({
        test:/\.s[ac]ss$/i,
        use : [
            CssExtractPlugin.loader,
            {
                loader:'css-loader',
                options:{
                    url:false,
                    importLoaders:2,
                    // 0 => no loaders (default);
                    // 1 => postcss-loader;
                    // 2 => postcss-loader, sass-loader
                }
            },
            'postcss-loader',           
            'sass-loader'
        ],
    });

    // script
    conf.module.rules.push({
        test: /\.(ts|tsx|js)$/,
        exclude: /node_modules/,
        use:{
            loader:"babel-loader",
            options:{
                presets: [
                    "@babel/preset-env",
                    "@babel/preset-react",
                    "@babel/preset-typescript",
                ],
                plugins: [
                    "@babel/plugin-syntax-dynamic-import", // already include in @babel/preset-env work without yarn add
                    "@babel/plugin-proposal-class-properties", // already include in @babel/preset-env work without yarn add
                    "@babel/plugin-proposal-object-rest-spread", // already include in @babel/preset-env work without yarn add

                    "@babel/plugin-transform-runtime", // use tarnsform runtime (async  / await) work without yarn add
                    "babel-plugin-transform-react-remove-prop-types" 
                ]
            },
        },
    });


    conf.devServer={
        headers: { 'Access-Control-Allow-Origin': '*' },
        static:{ directory:path.join(__dirname,"public","assets"), }, 
        watchFiles: [
            './app/Views/**/*.twig',
        ],
        historyApiFallback: {
            disableDotRule: true
        },        
        open: false,
        compress: true,
        devMiddleware:{
            writeToDisk:function(filepath)
            {
                // like folder
                return /[\\/](css|js|workers)[\\/]/;               
            },
        },
    };


    conf.optimization.runtimeChunk='single';

    conf.optimization.splitChunks={
        cacheGroups:{
            xlsx: {
                test: /[\\/]node_modules[\\/](xlsx|sheetjs-style)[\\/]/,
                name: "ven.xlsx",
                enforce:true,
                priority:30
            },
            any:{
                test:path.resolve(__dirname,"src","any"),
                name:"any",
                chunks:"all"
            }
        }
    }
    if(isProd)
    {
        // add bundle analizer size
        //conf.plugins.push(new BundleAnalyzerPlugin());
        //minimize css
        conf.optimization.minimizer.push(new CssMinify());
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