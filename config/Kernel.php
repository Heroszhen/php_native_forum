<?php
namespace config;

use config\router\Router;

class Kernel{
    public function run(){
        $router = new Router();
        $router->setRoutes();
        $router->getRouter();
    }
}