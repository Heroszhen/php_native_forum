<?php

class Crawler{

    public function run(string $url){
        $html = file_get_contents($url);
        return $html;
    }
}