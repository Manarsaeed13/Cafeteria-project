<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$config = [
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'cafeteria', 
    'charset' => 'utf8mb4'
];

require_once '../Database.php';
$db = new Database($config, 'root', ''); 

