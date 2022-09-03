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
        <?php
            include_once "../templates/filters.php";

            foreach($allcategories as $data){
        ?>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?= $data["title"] ?></h3>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?= formatDate($data['created']) ?>
                        </h6>
                        <a href="#" class="card-link">Modifier</a>
                        <a href="#" class="card-link"><?= count($data['articles']) ?> articles</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

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
                ...
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("openmodal1").addEventListener('click',function(e){
        console.log(this,e.target);
        document.querySelector("button[data-bs-target='#modal1']").click();
    })
</script>

<?php
require_once "../templates/footer.php";
?>