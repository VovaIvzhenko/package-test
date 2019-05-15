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

new \app\Router();