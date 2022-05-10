const ctx: Worker = self as any;

onmessage=(event:any)=>
{
    console.log("Worker 2 Receit ",event.data);
}

export default null as any;