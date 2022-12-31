<?php
namespace src\controller;

use config\AbstractController;
use src\entity\User;
use src\observers\UserSubject;
use src\observers\LoginEmailObserver;
use src\observers\LoginSMSObserver;
use vendor\ZEmail\Email;
use src\entity\Category;
use src\entity\Article;
use src\entity\Comment;
use src\service\ToolsService;

class HomeController extends AbstractController{
    
    public function index(){
        $_SESSION['page'] = "home";

        $allcategorys = $this->entity->findAll(Category::class);
        foreach($allcategorys as $key=>$category){
            //$articles = $this->entity->findBy(new Article(), ["category_id"=>$category["id"]], "desc", "id",  5);
            $req = "select a.id, a.title, a.content, a.created, u.name as username
                    from article a, user u
                    where a.user_id = u.id
                    and a.category_id = :cid
                    order by a.id desc
                    limit 5
            ";
            $articles = ($this->entity->execRequete($req,['cid'=>$category['id']]))->fetchAll();
            foreach($articles as $key2=>$article){
                $comments = $this->entity->findBy(Comment::class,['article_id'=>$article["id"]]);
                $articles[$key2]["total_comments"] = count($comments);
            }
            $allcategorys[$key]["articles"] = $articles;
        }
        $this->render("home/index.php",[
            "allcategorys" => $allcategorys
        ]);
    }

    public function login(){
        if(isset($_SESSION["user"]))$this->Toredirect("");
        $_SESSION['page'] = "login";
        $this->flashbag->empty();

        $user = new User();
        if(isset($_POST["action"]) && $_POST['action'] == "login"){
            $user->setAttributs($_POST);
            $result = $user->findBy(
                User::class,
                ["email" => $user->getEmail()],
                "","", 2);
            if(count($result) != 0){
                if(password_verify($user->getPassword(), $result[0]['password']) == true){
                    unset($result[0]["password"]);
                    $_SESSION["user"] = $result[0];

                    $observer1 = new LoginEmailObserver(new Email());
                    $observer2 = new LoginSMSObserver(null);
                    $user->setAttributs($result[0]);
                    $us = new UserSubject($user);
                    $us->attach($observer1);
                    $us->attach($observer2);
                    $us->notify();

                    $this->Toredirect("/");
                }
            }
            $this->flashbag->set(
                "Erreurs",
                "error"
            );
        }
        $this->render("home/login.php",[
            "user" => $user,
            "flashbag" => $this->flashbag->get()
        ]);
    }

    public function logout(){
        unset($_SESSION["user"]);
        $this->Toredirect("/");
    }

    public function article(int $id){
        $_SESSION['page'] = "article";

        $article = $this->entity->findById(Article::class,$id);

        $req = "select name from user where id = :id";
        $result = $this->entity->execRequete($req, [
            "id" => $article["user_id"]
        ]);
        $user = $result->fetch();

        $req = "select c.id, c.content, c.created, u.name as username
                from comment c, user u
                where c.user_id = u.id
                and c.article_id = :aid
                order by c.id desc
        ";
        $comments = ($this->entity->execRequete($req,['aid'=>$article['id']]))->fetchAll();
        //ToolsService::dump($comments);
        $this->render("home/article.php",[
            "article" => $article,
            "user" => $user,
            "comments" => $comments
        ]);
    }

    public function editComment(){
        $post = $_POST;
        if(isset($_SESSION["user"]) && isset($post['action']) && $post["action"] == "reply_article"){
            $comment = new Comment();
            $post["content"] = htmlspecialchars($post["content"]);
            $post["article_id"] = (int)$post["article_id"];
            $post["user_id"] = $_SESSION['user']['id'];
            $comment->persist($comment,$post);
            $this->Toredirect("/post/{$post['article_id']}");
            return;
        }
        //$this->Toredirect("/");
    }
}