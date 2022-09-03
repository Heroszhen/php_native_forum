<?php

return [
    ['GET','/', [],  \src\controller\HomeController::class,"index"],
    ['GET','/article', ['\d+'], \src\controller\HomeController::class,"getArticle"],
    ['GET','/connexion', [],  \src\controller\HomeController::class,"login"],
    ['POST','/connexion', [],  \src\controller\HomeController::class,"login"],
    ['GET','/deconnexion', [],  \src\controller\HomeController::class,"logout"],
    ['GET','/admin/tous-les-articles', [],  \src\controller\admin\AdminController::class,"index"],
    ['GET','/admin/delete-article/', ['\d+'],  \src\controller\admin\AdminController::class,"deleteArticle"],
    ['GET','/admin/ajouter-article/', ['\d+'],  \src\controller\admin\AdminController::class,"editArticle"],
    ['POST','/admin/ajouter-article/', ['\d+'],  \src\controller\admin\AdminController::class,"editArticle"],
    ['GET','/admin/toutes-les-categories', [],  \src\controller\admin\AdminController::class,"getAllCategories"],
];