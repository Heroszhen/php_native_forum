<?php
require_once "../templates/header.php";
?>
        <style>
           
        </style>
    </head>
    <body>
<?php
require_once "../templates/admin/adminnav.php";
?>

<div id="allcategories" class="admin container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="d-flex align-items-center">
                Les catégories
                <i class="bi bi-plus-circle-fill pointer mt-1" id="openmodal1" style="margin-left:10px;font-size:20px;"></i>
            </h1>
        </div>
    </div>
    <div class="row" id="allcategories">
        <?php
            include_once "../templates/filters.php";

            foreach($allcategories as $data){
        ?>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card" data-id="<?= $data['id'] ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?= $data["title"] ?></h3>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?= formatDate($data['created']) ?>
                        </h6>
                        <a href="#" class="card-link editcategory">Modifier</a>
                        <a href="#" class="card-link getarticles"><?= count($data['articles']) ?> articles</a>
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
            <h6 class="card-subtitle mb-2 text-muted">
            </h6>
            <a href="#" class="card-link editcategory">Modifier</a>
            <a href="#" class="card-link getarticles"></a>
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
            post("/admin/edit-category/" + id,{title:title}).then((data)=>{
                console.log(data)
            });
        }
    })
</script>

<?php
require_once "../templates/footer.php";
?>