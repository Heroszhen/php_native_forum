<?php
require_once "Crawler.php";

function execRequete(string $req, array $params = [], PDO $pdo){
    // Sanitize
    if ( !empty($params)){
        foreach($params as $key => $value){
            $params[$key] = trim(strip_tags($value));
        }
    }

    $r = $pdo->prepare($req);
    $r->execute($params);
    if( !empty($r->errorInfo()[2]) ){
        die('Erreur rencontrée lors de la requête : '.$r->errorInfo()[2]);
    }

    return $r;
}

$config = include dirname(__DIR__)."/config.php";
$pdo = new PDO(
    'mysql:host='.$config["host"].';dbname='.$config["dbname"],
    $config["username"],
    $config["password"],
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
);


//drop tables
$tab = ["employment","lesson","comment","article","category","user"];
try {
    foreach($tab as $one){
        $sql = "DROP TABLE ".$one;
        $result = $pdo->exec($sql);
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$tab = [];
$sql = "CREATE TABLE IF NOT EXISTS  user(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL DEFAULT '',
    password VARCHAR(255) NOT NULL DEFAULT '',
    name VARCHAR(50) NOT NULL DEFAULT '',
    address VARCHAR(255) NOT NULL DEFAULT '',
    roles VARCHAR(10) DEFAULT '',
    removed TIMESTAMP NULL DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
array_push($tab,$sql);

$sql = "CREATE TABLE IF NOT EXISTS  category(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
array_push($tab,$sql);

$sql = "CREATE TABLE IF NOT EXISTS  article(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL DEFAULT '',
    content LONGTEXT NOT NULL DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
)";
array_push($tab,$sql);

$sql = "CREATE TABLE IF NOT EXISTS  comment(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    article_id INT(11) NOT NULL,
    content LONGTEXT NOT NULL DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (article_id) REFERENCES article(id)
)";
array_push($tab,$sql);

$sql = "CREATE TABLE IF NOT EXISTS  lesson(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL DEFAULT '',
    content LONGTEXT NOT NULL DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
)";
array_push($tab,$sql);

$sql = "CREATE TABLE IF NOT EXISTS  employment(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL DEFAULT '',
    content LONGTEXT NOT NULL DEFAULT '',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id)
)";
array_push($tab,$sql);

try {
    foreach($tab as $sql){
        $result = $pdo->exec($sql);
    }
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

//add users
$hash = password_hash("aaaaaaaa", PASSWORD_DEFAULT);
execRequete(
    "INSERT INTO user (email,password,name,address,roles) VALUES (:email, :password, :name, :address, :roles)",
    [
        "email" => "herosgogogogo@gmail.com",
        "password" => $hash,
        "name" => "zhen",
        "address" => "13 rue de France",
        "roles" => "admin"
    ],
    $pdo
);
execRequete(
    "INSERT INTO user (email,password,name,address,roles) VALUES (:email, :password, :name, :address, :roles)",
    [
        "email" => "vincent@gmail.com",
        "password" => $hash,
        "name" => "vincent",
        "address" => "13 rue de France",
        "roles" => "visitor"
    ],
    $pdo
);

//add categories
$tab = ["php","javascript","css"];
foreach($tab as $one){
    execRequete(
        "INSERT INTO category (title) VALUES (:title)",
        ["title" => $one],
        $pdo
    );
}

//add articles
for($i = 0; $i < 30; $i++){
    $content = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";
    $user_id = rand(1,2);
    $category_id = rand(1,3);
    $title = substr($content, $i * 5 , 5);;
    execRequete(
        "INSERT INTO article (user_id, category_id, title, content) VALUES (:user_id, :category_id, :title, :content)",
        [
            "user_id" => $user_id,
            "category_id" => $category_id,
            "title" => $title,
            "content" => $content
        ],
        $pdo
    );
}
