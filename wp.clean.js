const glob=require("glob");
const fse=require("fs-extra");

async function removeFile(file)
{
    try {
        await fse.removeSync(file)
        console.log(`success remove ${file}`)
    } catch (err) {
        console.error(err)
    }
}

const doRemove=(extension)=>{
    const files=glob.sync(`./public/assets/*.${extension}`);
    files.forEach((file) => {
        removeFile(file);
    });
};

module.exports={
    doRemove
}