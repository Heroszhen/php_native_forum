<?php
require_once "../templates/header.php";
?>  
        <style>
           
        </style>
    </head>
    <body>
<?php
require_once "../templates/nav.php";
include_once "../templates/filters.php";
?>
    <div class="theme">
        <div class="container pt-5" id="article">
            <div class="row">
                <h2 class="mb-3"><?= $article['title'] ?></h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <article class="onearticle">    
                        <div class="author">
                            <div class="name"><?= $user['name'] ?></div>
                            <div class="created"><?= formatDate($article["created"]) ?></div>
                        </div>
                        <div class="content">
                            <?= htmlspecialchars_decode($article["content"]) ?>
                        </div>
                    </article>
                    <?php 
                        foreach($comments as $item){
                    ?>
                        <article class="onearticle">    
                            <div class="author">
                                <div class="name"><?= $item['username'] ?></div>
                                <div class="created"><?= formatDate($item["created"]) ?></div>
                            </div>
                            <div class="content">
                                <?= htmlspecialchars_decode($item["content"]) ?>
                            </div>
                        </article>
                    <?php 
                        }
                    ?>
                </div>
                <?php if(isset($_SESSION['user'])){ ?>
                <div class="col-12 mt-5">
                    <section class="panel-header">Répondre</section>
                    <section>
                        <form method="post" action="/edit-comment">
                            <div>
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            </div>
                            <div class="col-12 text-center bg-white p-2">
                                <input class="d-none" name="action" value="reply_article">
                                <input class="d-none" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" class="btn btn-primary no-radius">Envoyer</button>
                            </div>
                        </form>
                    </section>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="../../js/libs/ckeditor_4.19.1_full/ckeditor.js"></script>
    <script src="../../js/libs/ckeditor_4.19.1_full/adapters/jquery.js"></script>
    <script>
        $(function() {
            $('textarea').ckeditor();
        });
    </script>
<?php
require_once "../templates/footer.php";
?>

