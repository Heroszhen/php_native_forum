<?php

function formatDate(string $datetime){
    $date = new DateTime($datetime);
    return $date->format("d/m/Y H:i:s");
}

function showArray(array $tab){
    echo "<pre>";
    var_dump($tab);
    echo "</pre>";
}