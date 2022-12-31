<?php
require_once "../templates/header.php";
?>  
        <style>
            #home .onecategory{
                margin-bottom:20px;
                box-shadow: 0 3px 1px 0 rgb(0 0 0 / 10%);
            }
            #home .onecategory a{
                color:black;
                text-decoration:none;
            }
            #home .onecategory .bi{
                cursor: pointer;
            }
            #home .onecategory .category-info{
                display:flex;
                justify-content: space-between;
                background-color: #888;
                color:white;
                padding:15px 20px;
            }
            #home .onecategory.close .bi-arrow-up-circle{
                display:none;
            }
            #home .onecategory .bi-arrow-down-circle{
                display:none;
            }
            #home .onecategory.close .bi-arrow-down-circle{
                display:block;
            }
            #home .onecategory #list-articles{
                transition:1s;
            }
            #home .onecategory.close #list-articles{
                height:0;
                overflow: hidden;
            }
            #home .onecategory .onearticle{
                display:block;
                padding: 10px 30px;
                background-color: #fff;
                transition:.5s;
                display:flex;
            }
            #home .onecategory .onearticle>div:nth-child(1){
                width:60%;
            }
            #home .onecategory .onearticle>div{
                width:13%;
                padding-right:10px;
                overflow: hidden;
            }
            #home .onecategory .onearticle>div:last-child{
                color: #3b96e2;
                font-weight:bold;
            }
            #home .onecategory .onearticle .content{
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                width:99%;
                height:24px;
            }
            #home .onecategory .onearticle:nth-child(even) {
                background-color: #f9f9f9;
            }
            #home .onecategory .onearticle:hover{
                cursor: pointer;
                position: relative;
                z-index: 35;
                box-shadow: 0 3px 25px 0 rgb(0 0 0 / 20%);
            }
        </style>
    </head>
    <body>
<?php
require_once "../templates/nav.php";
?>
    <div class="container mt-5" id="home">
        <div class="row">
            <div class="col-12">
                <?php
                    foreach($allcategorys as $data){
                ?>
                    <div class="onecategory">
                        <div class="category-info">
                            <div class="category-title">
                                <a href="/categorie/<?= $data['id'] ?>" class="text-white"><?= $data["title"] ?></a>
                            </div>
                            <div class="category-arrow">
                                <i class="bi bi-arrow-up-circle"></i>
                                <i class="bi bi-arrow-down-circle"></i>
                            </div>
                        </div>
                        <div id="list-articles">
                            <?php
                                include_once "../templates/filters.php";
                                foreach($data["articles"] as $data2){
                            ?>
                                <a href="/post/<?= $data2['id'] ?>" class="onearticle">
                                    <div>
                                        <?= $data2["title"] ?>
                                        <div class="content"><?= htmlspecialchars_decode($data2["content"]) ?></div>
                                    </div>
                                    <div><?= $data2["username"] ?></div>
                                    <div><?= formatDate($data2["created"]) ?></div>
                                    <div><?= $data2["total_comments"] ?> commentaires</div>
                                </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll(".category-arrow").forEach((elm)=>{
            elm.addEventListener("click",(e)=>{
                let category = elm.parentElement.parentElement;
                if(category.classList.contains("close"))category.classList.remove("close");
                else category.classList.add("close");
            });
        });
    </script>
<?php
require_once "../templates/footer.php";
?>

