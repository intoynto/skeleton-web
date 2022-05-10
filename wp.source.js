const fs=require("fs");
const glob=require("glob");

function applyProp(name,ext)
{
    return `web.${name}`;
}

function fileExists(file)
{
    try {
        return fs.existsSync(file);
    }
    catch(e)
    {
        return false;
    }
}

function toScanDir(paths,useDepend=false)
{
    const scands={};
    const fileCss=[];
    const fileJs=[];
    const checkScand={};

    const toFiles=(baseName,files)=>
    {
        baseName=baseName.split('.');
        baseName.shift(); // remove first array
        baseName=baseName.join(".");

        for(let i=0; i<files.length; i++)
        {
            split=files[i].split("/");
            const fileName=split[split.length-1];
            split=fileName.split(".");
            const ext=(split[split.length-1]||'').toString().toLowerCase();
            split.pop(); // remove last array            
            let name=`${baseName}`;
            name=applyProp(name,ext);
            const isCss=['css','scss','sacss'].indexOf(ext)>=0;
            if(isCss)
            {
                name=name+'.style';
                fileCss.push(files[i]);
            }
            else {
                fileJs.push(files[i]);
            }

            if(scands[name])            
            {
                if(!checkScand[name])
                {
                    checkScand[name]=0;
                }        
                checkScand[name]++;        
                name+=checkScand[name];
            }
            if(isCss || !useDepend)
            {
                scands[name]=files[i];
            }
            else {
                scands[name]={
                    import:files[i],
                    dependOn:'shared',
                };
            }
        }
    };

    for(let i=0; i<paths.length; i++)
    {
        const splitPath=paths[i].split('/');
        const end=splitPath[splitPath.length-1];
        const pola=/web\.([a-zA-Z\.]+)/;
        if(pola.test(end))
        {
            let p=paths[i];
            const fsource=fileExists(`${p}/index.tsx`)?"index.tsx" 
                          :fileExists(`${p}/index.ts`)?"index.ts"
                          :null;
            const ext = fileExists(`${p}/index.tsx`)?"tsx"
                       : fileExists(`${p}/index.ts`)?"ts"
                       : null;

            if(fsource)
            {
                p=end.split('.');
                p.shift(); // remove first array
                p=p.join(".");

                p=applyProp(p,ext);

                if(useDepend)
                {
                    scands[p]={
                        import:`${paths[i]}/${fsource}`,
                        dependOn:'shared',
                    }
                }
                else {
                    scands[p]=`${paths[i]}/${fsource}`;
                }
            }
            else {
                // scand on by one files
                const files=glob.sync(`${paths[i]}/*.tsx`);
                toFiles(end,files);
            }
        }
    }
    return {
        js:fileJs,
        css:fileCss,
        merge:scands,
    };
}


module.exports={toScanDir}