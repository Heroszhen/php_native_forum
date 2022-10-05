<?php
namespace config;

use PDO;
use config\ConnectSql;

abstract class AbstractEntity{
    private $pdo;

    public function __construct(){   
        $this->pdo = ConnectSql::getDB();
    }

    public function setAttributs(array $attributs){
        foreach($attributs as $key=>$value){
            if(property_exists($this,$key))call_user_func(array($this, 'set'.ucfirst($key)),$value);
        }
    }

    public function getPDO(){
        return $this->pdo;
    }

    public function execRequete(string $req, array $params = []){
        // Sanitize
        if ( !empty($params)){
            foreach($params as $key => $value){
                $params[$key] = trim(strip_tags($value));
            }
        }
    
        $r = $this->pdo->prepare($req);
        $r->execute($params);
        if( !empty($r->errorInfo()[2]) ){
            die('Erreur rencontrée lors de la requête : '.$r->errorInfo()[2]);
        }
    
        return $r;
    }

    private function getClassname(object $object){
        $fullname = get_class($object);
        $tab = explode("\\",$fullname);
        $name = end($tab);
        return strtolower($name);
    }

    public function findById(object $object,int $id){
        $classname = $this->getClassname($object);
        $req = "SELECT * From $classname WHERE id = :id";
        $result = $this->execRequete($req, ["id"=>$id])->fetch();

        return $result;
    }

    public function findAll(object $object,string $order = "", string $field = "",int $limit = null){
        $classname = $this->getClassname($object);
        $req = "SELECT * From $classname";
        if($order != "")$req .= " ORDER BY $field $order";
        if($limit != null)$req .= " LIMIT $limit";

        $result = $this->execRequete($req, [])->fetchAll();
        return $result;
    }

    public function findBy(object $object, array $fields, string $order = "", string $field = "",  int $limit = null){
        $classname = $this->getClassname($object);
        $req = "SELECT * FROM $classname";
        if(count($fields) > 0)$req .= " WHERE ";
        $index = 0;
        foreach($fields as $key=>$value){
            $req .= $key."=:".$key;
            if($index < count($fields) - 1)$req .= "AND";
            $index++;
        }
        $req .= " GROUP BY id";
        if($order != "")$req .= " ORDER BY $field $order";
        if($limit != null)$req .= " LIMIT $limit";
        
        $result = $this->execRequete($req, $fields)->fetchAll();
        return $result;
    }

    public function remove(object $object, array $fields){
        $classname = $this->getClassname($object);
        $req = "DELETE FROM $classname";
        if(count($fields) > 0)$req .= " WHERE ";
        $index = 0;
        foreach($fields as $key=>$value){
            $req .= $key."=:".$key;
            if($index < count($fields) - 1)$req .= "AND";
            $index++;
        }
        $this->execRequete($req, $fields);
    }

    public function persist(object $object, array $fields){
        $classname = $this->getClassname($object);
        if($object->getId() == null){
            $req = "INSERT INTO $classname (";
            $req2 = " VALUES (";
            $index = 0;
            foreach($fields as $key=>$value){
                if(property_exists($object, $key) && $key != 'id'){
                    $req .= $key;
                    $req2 .= ":$key";
                    if($index < count($fields) - 1){
                        $req .= ",";
                        $req2 .= ",";
                    } 
                }
                $index++;
            }
            $req .= ")";
            $req2 .= ")";
            $this->execRequete($req.$req2, $fields);
            return $this->pdo->lastInsertId();
        }else{
            $req = "UPDATE $classname SET ";
            $index = 0;
            foreach($fields as $key=>$value){
                if(property_exists($object, $key) && $key != 'id'){
                    $req .= "$key = :$key";
                    if($index < count($fields) - 1)$req .= ",";
                }
                $index++;
            }
            $req .= " WHERE id = :id";
            $fields["id"] = $object->getId();
            $this->execRequete($req, $fields);
            return $object->getId();
        }
    }
}