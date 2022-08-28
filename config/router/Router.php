<?php
namespace config\router;

class Router{
    private $routes = [];

    public function setRoutes(){
        $this->routes = include dirname(__DIR__)."/router/routes.php";
    }

    function getRouter(){
        $method = $_SERVER["REQUEST_METHOD"];
        $url = $_SERVER["REQUEST_URI"];
        $index = $this->searchRoute($method, $url);
        if($index != -1){
            $route = $this->routes[$index];
            $parameters = [];
            if(count($route[2]) > 0){
                $tab = explode('/',$url);
                $last = array_pop($tab);
                $tab = explode("_",$last);
                foreach($tab as $value)$parameters[] = $value;
            }
            call_user_func_array([new $route[3](),$route[4]], $parameters);
        }
    }

    public function searchRoute(string $method, string $url):int{
        $index = -1;
        foreach($this->routes as $key=>$value){
            if(strtolower($value[0]) == strtolower($method)){//compare methods
                if(count($value[2]) == 0){
                    if($value[1] == $url){
                        $index = $key;
                        break;
                    }
                }else{//compare stocked routes and url
                    $exp = $value[1];
                    $exp = str_replace("/", "\/", $exp, $count);
                    foreach($value[2] as $key2=>$value2){
                        if($key2 < count($value[2]) - 1)$exp .= $value2 . "_";
                        else $exp .= $value2;
                    }
                    $exp = '/^('.$exp.')$/';
                    preg_match($exp, $url, $matches);
                    if(count($matches) > 0){
                        $index = $key;
                        break;
                    }
                }
            }
        }

        return $index;
    }
}