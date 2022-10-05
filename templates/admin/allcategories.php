<?php
require_once "../templates/header.php";
?>
        <style>
           .card .card-title{
                cursor: pointer;
           }
           .card .input-title{
                display:none;
           }
        </style>
    </head>
    <body>
<?php
require_once "../templates/admin/adminnav.php";
?>

<div id="allcategories" class="admin container-fluid" onclick="closeAll()">
    <div class="row">
        <div class="col-12">
            <h1 class="d-flex align-items-center">
                Les catégories
                <i class="bi bi-plus-circle-fill pointer mt-1" id="openmodal1" style="margin-left:10px;font-size:20px;"></i>
            </h1>
        </div>
    </div>
    <div class="row" id="list-categories">
        <?php
            include_once "../templates/filters.php";

            foreach($allcategories as $data){
        ?>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card" data-id="<?= $data['id'] ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?= $data["title"] ?></h3>
                        <input class="form-control mb-2 input-title" type="text" placeholder="titre" value="">
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?= formatDate($data['created']) ?>
                        </h6>
                        <a href="#" class="card-link getarticles" onclick="getArticles(event)"><?= count($data['articles']) ?> articles</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<template id="template-category">
    <div class="col-md-4 col-lg-3 mb-3">
        <div class="card" data-id="">
            <div class="card-body">
                <h3 class="card-title"></h3>
                <h6 class="card-subtitle mb-2 text-muted"></h6>
                <a href="#" class="card-link getarticles" onclick="getArticles(event)"></a>
            </div>
        </div>
    </div>
</template>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#modal1">
  Launch static backdrop modal
</button>
<!--modal 1-->
<div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal1Label">Modifier une Catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="category_title" placeholder="titre" value="">
                </div>
                <input class="d-none" type="number" name="id" value="">
                <div class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-editcategory">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#modal2">
  Launch static backdrop modal
</button>
<div class="modal fade" id="modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-2" aria-labelledby="modal2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal2Label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script>
    document.getElementById("openmodal1").addEventListener('click',(e)=>{
        document.querySelector("input#category_title").value = "";
        document.querySelector("input[name='id']").setAttribute("value",0);
        document.querySelector("button[data-bs-target='#modal1']").click();
    })
    document.getElementById("btn-editcategory").addEventListener('click',(e)=>{
        let title = document.getElementById("category_title").value;
        let id = parseInt(document.querySelector("input[name='id']").value);
        if(title != ""){
            editCategory(id,title);
        }
    })

    function closeAll(){
        if(card != null) editCategory(parseInt(card.getAttribute("data-id")),card.querySelector('.input-title').value);
        else card = null;
        document.querySelectorAll(".card .card-title").forEach((elm)=>{
            elm.classList.remove("d-none");
        });
        document.querySelectorAll(".card .input-title").forEach((elm)=>{
            elm.classList.remove("d-block");
        });
    }
    function closeCard(){
        if(card != null){
            card.querySelector(".input-title").classList.remove("d-block");
            card.querySelector(".card-title").classList.remove("d-none");
        }
        card = null;
    }
    document.querySelectorAll(".card .card-title").forEach((e)=>{
        e.addEventListener('dblclick',openInputTitle);
    });
    let card = null;
    function openInputTitle(e){
        e.stopPropagation();
        closeAll();
        e.target.classList.add("d-none");
        card = e.target.parentNode.parentNode;
        let input = card.querySelector(".input-title");
        input.value = e.target.textContent;
        input.classList.add("d-block");
    }
    document.querySelectorAll(".card .input-title").forEach((e)=>{
        e.addEventListener('click',clickInputTitle);
        e.addEventListener('keyup',changeInputTitle);
    });
    function clickInputTitle(e){e.stopPropagation();}
    function changeInputTitle(e){
        e.stopPropagation();
        if(e.keyCode == 13){//to save
            editCategory(parseInt(card.getAttribute("data-id")),card.querySelector('.input-title').value);
        }
    }
    function editCategory(id,title){
        post("/admin/edit-category/" + id,{title:title}).then((data)=>{
            let response = JSON.parse(data);
            if(id == 0){
                if ('content' in document.createElement('template')) {
                    const template = document.querySelector('#template-category');
                    const clone = template.content.cloneNode(true);
                    let div = clone.querySelector(".col-lg-3");
                    div.querySelector(".card").setAttribute("data-id",response["data"]["id"]);
                    div.querySelector(".card-title").textContent = response['data']["title"];
                    div.querySelector(".card-subtitle").textContent = dayjs(response['data']["created"]).format ('DD/MM/YYYY HH:mm:ss');
                    div.querySelector(".getarticles").textContent = "0";
                    document.getElementById("list-categories").prepend(div);
                }
                document.getElementById("modal1").querySelector(".btn-close").click();
            }else{
                card.querySelector(".card-title").textContent = response['data']["title"];
            }
            closeCard();
            openBoxAlert("Enregistré",2);
        });
    }

    async function getArticles(e){
        let id = e.target.parentElement.parentElement.getAttribute("data-id");
        let response = await get("/admin/getarticlesbycategoryid/" + id);
        let allarticles = (JSON.parse(response))["allarticles"];console.log(allarticles);
        let modal2 = document.getElementById("modal2");
        let modalbody = modal2.querySelector(".modal-body");
        let str = "";
        for(let entry of allarticles){
            str += `
                <div>
                    <a href="" target="_blank">${entry['title']}</a>
                </div>
            `;
        }
        modalbody.innerHTML = str;
        document.querySelector("button[data-bs-target='#modal2']").click();
    }
</script>

<?php
require_once "../templates/footer.php";
?>