<?php
namespace src\controller\admin;

use config\AbstractController;
use config\ConnectSql;
use src\service\ToolsService;
use src\entity\Article;
use src\entity\Category;

class AdminController extends AbstractController{
    //get all articles
    public function index(){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["roles"] != "admin")$this->Toredirect("");
        $_SESSION['page'] = "adminallarticles";

        $article = new Article();
        $req = "SELECT a.id, a.user_id, a.category_id, a.title, a.content, a.created, u.name as user_name, c.title as category_title 
                FROM article a, category c, user u
                WHERE a.user_id = u.id
                AND a.category_id = c.id
                GROUP BY a.id
                ORDER By a.id DESC
        ";
        $allarticles = $article->execRequete($req, []);
        $allarticles = $allarticles->fetchAll();
        $this->render("admin/index.php",[
            "allarticles" => $allarticles
        ]);
    }

    public function deleteArticle(int $id){
        $response = [
            "status" => 0,
            "data" => ""
        ];
        if(isset($_SESSION["user"]) && $_SESSION["user"]["roles"] == "admin"){
            $response["status"] = 1;
            $article = new Article();
            $article->remove($article, ["id" => $id]);
        }
        $this->json($response);
    }

    public function editArticle(int $id){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["roles"] != "admin")$this->Toredirect("");

        $this->flashbag->empty();
        
        $category = new Category();
        $allcategorys = $category->findAll($category,"asc","title");

        $article = new Article();
        if($id != 0){
            $result = $article->findById($article,$id);
            $article->setAttributs($result);
        }
        if(isset($_POST["action"]) && $_POST["action"] == "editarticle"){
            $article->setAttributs($_POST);
            if($article->getTitle() == "" || $article->getCategory_id() == 0){
                $this->flashbag->set(
                    "Veuillez remplir les champs obligatoires",
                    "error"
                );
            }else{
                unset($_POST["action"]);
                $_POST["user_id"] = $_SESSION["user"]["id"];
                $_POST["content"] = htmlspecialchars($_POST["content"]);
                $article->persist($article,$_POST);
                
                /*
                if($id == 0){
                    $req = "INSERT INTO article (user_id,category_id,title,content) VALUES (:user_id,:category_id,:title,:content)";
                    $params = [
                        "user_id" => $_SESSION["user"]["id"],
                        "category_id" => $article->getCategory_id(),
                        "title" => $article->getTitle(),
                        "content" => $article->getContent()
                    ];
                }else{
                    $req = "UPDATE article SET category_id = :category_id, title = :title, content = :content WHERE id = :id";
                    $params = [
                        "category_id" => $article->getCategory_id(),
                        "title" => $article->getTitle(),
                        "content" => $article->getContent(),
                        "id" => $id
                    ];
                }
                $this->execRequete($req, $params, $pdo);
                */
                if($id == 0){
                    $this->Toredirect("/admin/tous-les-articles");
                }else{
                    $this->flashbag->set(
                        "Enregistré",
                        "success"
                    );
                }
            }
        }
        $this->render("admin/onearticle.php",[
            "id" => $id,
            "allcategorys" => $allcategorys,
            "article" => $article,
            "flashbag" => $this->flashbag->get()
        ]);
    }

    public function getAllCategories(){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["roles"] != "admin")$this->Toredirect("");
        $_SESSION['page'] = "adminallcategorys";

        $allcategories = $this->entity->findAll(new Category(),"ASC", "title");
        foreach($allcategories as $key=>$one){
            $req = "SELECT id FROM article WHERE category_id = :category_id";
            $tab = $this->entity->execRequete($req, ['category_id'=>$one['id']])->fetchAll();
            $allcategories[$key]["articles"] = $tab;
        }
        $this->render("admin/allcategories.php",[
            "allcategories" => $allcategories
        ]);
    }

    public function editCategory(int $id){
        $response = [
            "status" => 0,
            "data" => ""
        ];
        if(isset($_SESSION["user"]) && $_SESSION["user"]["roles"] == "admin"){
            $response["status"] = 1;
            
        }
        $this->json($response);
    }
}