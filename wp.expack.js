const path=require("path");
const pkg=path.resolve(__dirname,"package.json");
const src=require(pkg);
var fs = require("fs");

console.log("============ explode dependencies ================== ");
if(typeof src==="object"){
    let str="";
    let str_all="";
    let str_dev="";
    let str_dev_all="";
    if(src.dependencies){        
        for(let p in src.dependencies){            
            if(str.length>0) str+="\n";
            if(str_all.length>0) str_all+=" ";
            str+='yarn add '+p+'@'+src.dependencies[p];
            str_all+=p;
        }        
        if(str_all.length>0){
            str_all="yarn add "+str_all;
        }
    }

    if(src.devDependencies){
        for(let p in src.devDependencies){
            if(str_dev.length>0) str_dev+="\n";
            if(str_dev_all.length>0) str_dev_all+=" ";
            str_dev+='yarn add '+p+'@'+src.devDependencies[p]+' --dev';
            str_dev_all+=p;
        }       
        if(str_dev_all.length>0){
            str_dev_all="yarn add "+str_dev_all+" --dev";
        }
    }

    let data="";
    if(str.length>0){
        data+="=============== dependencies using =================\n";
        data+=str;
    }

    if(str_dev.length>0){
        data+="\n\n=============== Device Depencies ===============\n";
        data+=str_dev;
    }

    if(str_all.length>0 || str_dev_all.length>0)
    {
        data+='\n\n\n==================== UP TO DATE using to ======================';
    }

    if(str_all.length>0){
        data+="\n\n=============== dependencies using up to date =================\n";
        data+=str_all;
    }

    if(str_dev_all.length>0){
        data+="\n\n=============== device dependencies using up to date =================\n";
        data+=str_dev_all;
    }

    if(data.length>0){
        fs.writeFile(path.resolve(__dirname,"install.txt"),data,function(err){
            if(err) throw err;
            console.log("install.txt saved!");
        });
    }
}