<?php
require_once "../autoload.php";

use config\Kernel;

session_start();

$kernel = new Kernel();
$kernel->run();