<?php
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
session_start();

$config = require BASE_PATH . 'config.php';
require_once BASE_PATH . 'Database.php';
require_once BASE_PATH . 'functions.php'; 
require_once BASE_PATH . 'Response.php';

$db = new Database($config);

$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $currentUser = $db->query("SELECT * FROM users WHERE ID = :id", [
        'id' => $_SESSION['user_id']
    ])->find();
    
    $_SESSION['user_role'] = $currentUser['role'] ?? 'user';
}

require BASE_PATH . 'router.php';
