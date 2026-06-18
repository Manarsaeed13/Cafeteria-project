<?php
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

session_start();
$config = require BASE_PATH . 'config.php';

require_once BASE_PATH . 'Database.php';
require_once BASE_PATH . 'functions.php'; 
require_once BASE_PATH . 'Response.php';

$db = new Database($config);
$adminData = $db->query("SELECT Name, Profile_picture FROM users WHERE ID = 2")->statement->fetch();

$current_admin_name = $adminData['Name'] ?? 'Guest';

$current_admin_image = $config['base_url'] . str_replace('\\', '/', $adminData['Profile_picture'] ?? '');

require BASE_PATH . 'router.php';