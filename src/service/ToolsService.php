<?php
namespace src\service;

class ToolsService{
    public static function dump(array $tab){
        echo "<pre>";
        var_dump($tab);
        echo "</pre>";
    }
}