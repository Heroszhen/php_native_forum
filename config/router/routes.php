<?php

return [
    ['GET','/', [],  \src\controller\HomeController::class,"index"],
    ['GET','/article', ['\d+'], \src\controller\HomeController::class,"getArticle"],
    ['GET','/connexion', [],  \src\controller\HomeController::class,"login"],
    ['POST','/connexion', [],  \src\controller\HomeController::class,"login"],
    ['GET','/deconnexion', [],  \src\controller\HomeController::class,"logout"],
    ['GET','/post/', ['\d+'],  \src\controller\HomeController::class,"article"],
    ['POST','/edit-comment', [],  \src\controller\HomeController::class,"editComment"],
    ['GET','/admin/tous-les-articles', [],  \src\controller\admin\AdminController::class,"index"],
    ['GET','/admin/delete-article/', ['\d+'],  \src\controller\admin\AdminController::class,"deleteArticle"],
    ['GET','/admin/ajouter-article/', ['\d+'],  \src\controller\admin\AdminController::class,"editArticle"],
    ['POST','/admin/ajouter-article/', ['\d+'],  \src\controller\admin\AdminController::class,"editArticle"],
    ['GET','/admin/toutes-les-categories', [],  \src\controller\admin\AdminController::class,"getAllCategories"],
    ['POST','/admin/edit-category/', ['\d+'],  \src\controller\admin\AdminController::class,"editCategory"],
    ['GET','/admin/getarticlesbycategoryid/', ['\d+'],  \src\controller\admin\AdminController::class,"getArticlesByCategory"],
    ['GET','/admin/deleteonecomment/', ['\d+'],  \src\controller\admin\AdminController::class,"deleteComment"],
];