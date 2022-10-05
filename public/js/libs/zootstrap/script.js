//box alert
function openBoxAlert(sentence,seconds=1){
    let box = document.getElementById("zootstrap-alert");
    if(box != null){
        box.querySelector(".body").textContent = sentence;
        box.classList.remove("d-none");
        setTimeout(()=>{
            box.classList.add("d-none");
        },seconds * 1000);
    }
}

document.querySelector("#zootstrap-alert .icon-x").addEventListener('click',(e)=>{
    document.getElementById("zootstrap-alert").classList.add("d-none");
});