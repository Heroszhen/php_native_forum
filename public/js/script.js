function post(url,data){
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type","application/json; charset=UTF-8");
        xhr.onreadystatechange = () =>{
            if(xhr.readyState === 4 && xhr.status === 200){
                resolve(xhr.response);
            }
        }
        let body = JSON.stringify(data);
        xhr.send(body);
    }); 
}

function get(url){
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onreadystatechange = () =>{
            if(xhr.readyState === 4 && xhr.status === 200){
                resolve(xhr.response);
            }
        }
        xhr.send();
    });   
}

//sort tr in table
function sortArrayDom(tab,column, sens, isNumber=false,isDate=false,selector=""){
    let v1;
    let v2;
    tab.sort((a,b)=>{
        v1 = a.querySelectorAll("td").item(column);
        if(selector != "")v1 = v1.querySelector(selector);
        v1 = v1.textContent.trim();
        v2 = b.querySelectorAll("td").item(column);
        if(selector != "")v2 = v2.querySelector(selector);
        v2 = v2.textContent.trim();
        if(isNumber == true){
            if(sens == 1)return parseFloat(v1) - parseFloat(v2);
            else return parseFloat(v2) - parseFloat(v1);
        }else if(isDate == true){
            if(sens == 1)return new Date(v1).getTime() - new Date(v2).getTime();
            else return new Date(v2).getTime() - new Date(v1).getTime();
        }else{
            if(sens == 1)return String(v1).localeCompare(String(v2));
            else return String(v2).localeCompare(String(v1));
        }
    });
    return tab;
}