<?php
namespace config;

use PDO;
use config\FlashBag;
use config\Entity;

abstract class AbstractController{
    protected $flashbag;
    protected $entity;

    public function __construct(){   
        $this->flashbag = new FlashBag();
        $this->entity = new Entity;
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
}