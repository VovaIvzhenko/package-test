<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

if (file_exists(ROOT . '/configs/config.php')) {
    require_once ROOT . '/configs/config.php';
}

if (empty($_POST)){
    $data = file_get_contents("php://input");
    if (!empty($data)){
        $_POST = json_decode($data, true);
    }
}
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');


new \app\Router();