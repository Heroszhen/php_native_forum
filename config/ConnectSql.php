<?php
namespace config;

use PDO;

class ConnectSql{
    private static $db = null;

    private function __construct() {}

    public static function getDB(){
        $config = include dirname(__DIR__)."/config/config.php";
        self::$db = new PDO(
            'mysql:host='.$config["host"].';dbname='.$config["dbname"],
            $config["username"],
            $config["password"],
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            )
        );
        
        return self::$db;
    }
}