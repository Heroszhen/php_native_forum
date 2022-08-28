<?php
namespace config;

class FlashBag{

    public function __construct(){   
        $bStatut = (session_status() === PHP_SESSION_ACTIVE ? true : false);
        if ($bStatut === false) session_start();
        $_SESSION["flashbag"] = null;
    }

    public function get(){
        return $_SESSION["flashbag"];
    }

    public function set(string $message,string $status){
        $_SESSION["flashbag"] = [
            "message" => $message,
            "status" => $status
        ];
    }

    public function empty(){
        $_SESSION["flashbag"] = null;
    }
}