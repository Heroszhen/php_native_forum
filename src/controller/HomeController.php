<?php
namespace src\controller;

use config\AbstractController;
use src\entity\User;
use src\observers\UserSubject;
use src\observers\LoginEmailObserver;
use src\observers\LoginSMSObserver;
use vendor\ZEmail\Email;

class HomeController extends AbstractController{
    
    public function index(){
        $_SESSION['page'] = "home";/*
        $pdo = ConnectSql::getDB();
        $req = "SELECT * FROM article";
        $allarticles = $this->execRequete($req, [], $pdo)->fetchAll();*/

        $this->render("home/index.php",[
            //"allarticles" => $allarticles
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
                $user,
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
}