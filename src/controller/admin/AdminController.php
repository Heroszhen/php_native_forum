<?php
namespace src\controller\admin;

use config\AbstractController;
use config\ConnectSql;
use src\service\ToolsService;
use src\entity\Article;
use src\entity\Category;
use src\entity\Comment;
use src\entity\User;

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
            $allcomments = $this->entity->findBy(Comment::class, ["article_id"=>$id]);
            foreach($allcomments as $tab)$this->entity->remove(Comment::class, ["id"=>$tab["id"]]);
            $article = new Article();
            $article->remove($article, ["id" => $id]);
        }
        $this->json($response);
    }

    public function editArticle(int $id){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["roles"] != "admin")$this->Toredirect("");

        $this->flashbag->empty();
        
        $allcategorys = $this->entity->findAll(Category::class,"asc","title");

        $allcomments = [];
        $article = new Article();
        if($id != 0){
            $result = $article->findById(Article::class,$id);
            $article->setAttributs($result);
            $req = "select c.id, c.content, c.created ,u.name as user_name
                    from user u, comment c
                    where c.user_id = u.id
                    and c.article_id = :aid
                    group by c.id
                    order by c.id desc
            ";
            $allcomments = ($this->entity->execRequete($req,['aid'=>$id]))->fetchAll();
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
                
                if($id == 0){
                    $this->Toredirect("/admin/tous-les-articles");
                }else{
                    $this->flashbag->set(
                        "Enregistr??",
                        "success"
                    );
                }
            }
        }
        $this->render("admin/onearticle.php",[
            "id" => $id,
            "allcategorys" => $allcategorys,
            "article" => $article,
            "allcomments" => $allcomments,
            "flashbag" => $this->flashbag->get()
        ]);
    }

    public function deleteComment(int $id){
        $response = [
            "status" => 0,
            "data" => ""
        ];
        if(isset($_SESSION["user"]) && $_SESSION["user"]["roles"] == "admin"){
            $response["status"] = 1;
            $comment = $this->entity->remove(Comment::class, ["id"=>$id]);
        }
        $this->json($response);
    }

    public function getAllCategories(){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["roles"] != "admin")$this->Toredirect("");
        $_SESSION['page'] = "adminallcategorys";

        $allcategories = $this->entity->findAll(Category::class,"ASC", "title");
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
        $postdata = file_get_contents("php://input");
        $array = (array)json_decode($postdata);
        $response = [
            "status" => 0,
            "data" => ""
        ];
        if(isset($_SESSION["user"]) && $_SESSION["user"]["roles"] == "admin"){
            $response["status"] = 1;
            $category = new Category();
            if($id != 0)$category->setId($id);
            $lastid = $this->entity->persist($category,$array);
            $found = $this->entity->findById(Category::class,$lastid);
            $req = "SELECT id FROM article WHERE category_id = :category_id";
            $tab = $this->entity->execRequete($req, ['category_id'=>$found['id']])->fetchAll();
            $found["articles"] = $tab;
            $response["data"] = $found;
        }
        $this->json($response);
    }

    public function getArticlesByCategory(int $id){
        $response = [
            "status" => 0,
            "data" => ""
        ];
        if(isset($_SESSION["user"]) && $_SESSION["user"]["roles"] == "admin"){
            $response["status"] = 1;
            $response["allarticles"] = $this->entity->findBy(Article::class, ["category_id"=>$id], "desc", "id");
        }
        $this->json($response);
    }
}