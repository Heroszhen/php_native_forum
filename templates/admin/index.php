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
        </style>
    </head>
    <body>
<?php
require_once "../templates/admin/adminnav.php";
?>

<div id="allarticles" class="admin container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Les articles</h1>
            <div class="data">
                <div class="d-flex">
                    <a class="btn btn-primary btn-sm me-2" href="/admin/ajouter-article/0">Ajouter</a>
                    <input class="form-control" type="text" id="research" placeholder="chercher..." style="width:200px;">
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="filter-title">
                                    Id
                                    <div>
                                        <div>
                                            <i class="bi bi-caret-up-fill" onclick="sortArticles(0,2,true)"></i>
                                        </div>
                                        <div>
                                            <i class="bi bi-caret-down-fill" onclick="sortArticles(0,1,true)"></i>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="filter-title">
                                    Titre
                                    <div>
                                        <div>
                                            <i class="bi bi-caret-up-fill" onclick="sortArticles(1,2,false,false,'.article-title')"></i>
                                        </div>
                                        <div>
                                            <i class="bi bi-caret-down-fill" onclick="sortArticles(1,1,false,false,'.article-title')"></i>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">Texte</th>
                            <th scope="col">
                                <div class="filter-title">
                                    Catégorie
                                    <div>
                                        <div>
                                            <i class="bi bi-caret-up-fill" onclick="sortArticles(3,2)"></i>
                                        </div>
                                        <div>
                                            <i class="bi bi-caret-down-fill" onclick="sortArticles(3,1)"></i>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="filter-title">
                                    Editeur
                                    <div>
                                        <div>
                                            <i class="bi bi-caret-up-fill" onclick="sortArticles(4,2)"></i>
                                        </div>
                                        <div>
                                            <i class="bi bi-caret-down-fill" onclick="sortArticles(4,1)"></i>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="filter-title">
                                    Créé
                                    <div>
                                        <div>
                                            <i class="bi bi-caret-up-fill" onclick="sortArticles(5,2,false,true,'.article-created')"></i>
                                        </div>
                                        <div>
                                            <i class="bi bi-caret-down-fill" onclick="sortArticles(5,1,false,true,'.article-created')"></i>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($allarticles as $key=>$one){
                        ?>
                            <tr>
                                <td><?= $one["id"] ?></td>
                                <td>
                                    <div class="article-title"><?= $one["title"] ?></div>
                                    <div class="article-content d-none"><?= htmlspecialchars_decode($one["content"]) ?></div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm showcontent">Lire</button>
                                </td>
                                <td><?= $one["category_title"] ?></td>
                                <td><?= $one["user_name"] ?></td>
                                <td>
                                    <?php
                                        include_once "../templates/filters.php";
                                        echo formatDate($one["created"]);
                                    ?>
                                    <div class="d-none article-created"><?= $one["created"] ?></div>

                                </td>
                                <td>
                                    <a href="/admin/ajouter-article/<?= $one['id'] ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <i class="bi bi-trash3-fill deletearticle"></i>
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
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" id="modal1" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
  Launch static backdrop modal
</button>
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel1"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
    // $( document ).ready(function() {
    //     let dt1 = $('#allarticles table').DataTable();
    // });

    document.querySelectorAll(".showcontent").forEach((elm, index)=>{
        elm.addEventListener("click",showContent);
    });
    function showContent(e){
        let button = e.target;//or button = this;
        let tr = button.parentNode.parentNode;
        addTrActive(tr);
        let modal1 = document.getElementById("staticBackdrop1");
        modal1.querySelector("#staticBackdropLabel1").innerHTML = tr.querySelector(".article-title").innerHTML;
        modal1.querySelector(".modal-body").innerHTML = tr.querySelector(".article-content").innerHTML;
        let modal1_btn = document.getElementById("modal1");
        modal1_btn.click();
    }

    function addTrActive(tr){
        document.querySelectorAll("tbody tr").forEach((elm,index)=>elm.classList.remove("active"));
        tr.classList.add("active");
    }

    let tab = [];
    let tab2 = [];
    let value;
    let alltd;
    let tbody = document.querySelector("tbody");
    document.getElementById("research").addEventListener("keyup",(e)=>{
        value = e.target.value.toLowerCase();
        tab = [];
        tab2 = [];
        tbody.querySelectorAll("tr").forEach((elm,index)=>{
            alltd = elm.querySelectorAll("td");
            if(
                alltd.item(0).textContent.toLowerCase().includes(value) ||
                alltd.item(1).querySelector(".article-title").textContent.toLowerCase().includes(value) ||
                alltd.item(3).textContent.toLowerCase().includes(value)
            )tab.push(elm)
            else tab2.push(elm)
        });
        tab = tab.concat(tab2);
        tbody.textContent = "";
        tab.forEach((elm,index)=>tbody.append(elm));
    });

    document.querySelectorAll(".deletearticle").forEach((elm,index)=>{
        elm.addEventListener("click",(e)=>{
            let tr = elm.parentNode.parentNode;
            let id = tr.querySelectorAll("td").item(0).textContent.trim();
            get("/admin/delete-article/" + id).then((data)=>{
                let response = JSON.parse(data)
                if(response["status"] == 1)tr.remove();
            });
        });
    });

    function sortArticles(column,sens,isNumber=false,isDate=false,selector=""){
        let tbody = document.querySelector("tbody");
        let alltrs = tbody.querySelectorAll("tr");
        let tab = [];
        alltrs.forEach((elm,index)=>tab.push(elm));
        tab = sortArrayDom(tab,column, sens, isNumber,isDate,selector);
        tbody.textContent = "";
        tab.forEach((elm,index)=>tbody.append(elm));
    }
</script>
<?php
require_once "../templates/footer.php";
?>
