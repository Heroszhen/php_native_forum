<?php
require_once "../templates/header.php";
?>
        <style>
            .bi{
                cursor: pointer;
            }
            .bi-pencil-fill{
                color:green;
                margin-right:10px;
            }
            .bi-trash3-fill{
                color:red;
            }
            .bi-trash3:hover{
                cursor: pointer;
                color:red;
            }
        </style>
    </head>
    <body>
<?php
require_once "../templates/admin/adminnav.php";
?>

<div id="admin-onearticle" class="admin container">
    <form class="row justify-content-center" method="post" action="/admin/ajouter-article/<?= $id ?>">
        <div class="col-12 h2 text-center mb-4">
            <?php
                if($id == 0)echo "Ajouter un article";
                else echo "Modifier un article";
            ?>
        </div>
        <?php
            if($flashbag != null){
        ?>
            <div class="col-12 mt-2 mb-2">
                <div class="alert alert-<?= ($flashbag['status'] == "error")?'danger':'success' ?>"><?= $flashbag['message'] ?></div>
            </div>
        <?php                   
            }
        ?>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="title">Titre *</label>
                <input class="form-control" type="text" name="title" id="title" value="<?= $article->getTitle() ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="category">Catégorie *</label>
                <select class="form-select" id="category" name="category_id" value="<?= $article->getCategory_id() ?>">
                    <option value="0" <?php if($article->getCategory_id() == 0){ ?>selected<?php } ?>></option>
                    <?php
                        foreach($allcategorys as $one){
                    ?>
                        <option value="<?= $one["id"] ?>" <?php if($one['id'] == $article->getCategory_id()){ ?>selected<?php } ?>><?= $one["title"] ?></option>
                    <?php    
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="content" class="form-label">Texte</label>
                <textarea class="form-control" id="content" name="content" rows="3">
                    <?= $article->getContent() ?>
                </textarea>
            </div>
        </div>
        <div class="col-12 mt-3 text-center">
            <input class="d-none" name="action" value="editarticle">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
    </form>
   
    <div class="row" style="margin-top:200px">
        <div class="col-12">
            <h4 class="mb-2">Les commentaires (<?= count($allcomments) ?>)</h4>
            <table class="table" id="table-comments">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Texte</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include_once "../templates/filters.php";
                        foreach($allcomments as $data){
                    ?>
                        <tr>
                            <th scope="row"><?= $data["id"] ?></th>
                            <td><?= $data["user_name"] ?></td>
                            <td><?= $data["content"] ?></td>
                            <td><?= formatDate($data['created']) ?></td>
                            <td data-id="<?= $data["id"] ?>">
                                <i class="bi bi-trash3"></i>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../../js/libs/ckeditor_4.19.1_full/ckeditor.js"></script>
<script src="../../js/libs/ckeditor_4.19.1_full/adapters/jquery.js"></script>
<script>
    $(function() {
        $('textarea').ckeditor();
    });
    document.getElementById("table-comments").querySelectorAll(".bi-trash3").forEach((elm)=>{
        elm.addEventListener("click",async (e)=>{
            let id = elm.parentElement.getAttribute("data-id");
            let response = await get("/admin/deleteonecomment/" + id);
            response = JSON.parse(response);
            if(response["status"] == 1)elm.parentElement.parentElement.remove();
        });
    });
</script>
<?php
require_once "../templates/footer.php";
?>
