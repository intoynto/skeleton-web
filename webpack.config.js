const configOne=require("./webpack.config.web");
const configWorker=require("./webpack.config.worker");

module.exports=function(env,args)
{    
    return [
        configWorker(env,args),
        configOne(env,args),
    ];
}