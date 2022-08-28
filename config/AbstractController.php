<?php
namespace config;

use PDO;
use config\FlashBag;

abstract class AbstractController{
    protected $flashbag;

    public function __construct(){   
        $this->flashbag = new FlashBag();
    }

    protected function render($file,$args=[]){
        //foreach($args as $key=>$value)${$key} = $value;
        extract($args);
        include_once dirname(__DIR__)."/templates/".$file;
    }

    protected function Toredirect($url){
        header("Location: ".$url);
    }

    protected function json(array $response){
        echo json_encode($response);
    }

    function execRequete(string $req, array $params = [], PDO $pdo){
        // Sanitize
        if ( !empty($params)){
            foreach($params as $key => $value){
                $params[$key] = trim(strip_tags($value));
            }
        }
    
        $r = $pdo->prepare($req);
        $r->execute($params);
        if( !empty($r->errorInfo()[2]) ){
            die('Erreur rencontrée lors de la requête : '.$r->errorInfo()[2]);
        }
    
        return $r;
    }
}