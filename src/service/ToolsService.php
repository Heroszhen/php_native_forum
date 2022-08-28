<?php
namespace src\service;

class ToolsService{
    function showArray(array $tab){
        echo "<pre>";
        var_dump($tab);
        echo "</pre>";
    }
}