<?php
require_once __DIR__ . '/../../Database.php';
$config = require __DIR__ . '/../../config.php';
$db = new Database($config); 
$config = require __DIR__ . '/../../config.php';
$base_url = $config['base_url']; 
$users = $db->query("SELECT Name FROM users")->get();
$rooms = $db->query("SELECT Room_number FROM rooms")->get();
$products = $db->query("SELECT * FROM products")->get();

$base_path = "D:/my web project/cafetaria-project/";

include $base_path . 'partions/admin-navbar.php';
include $base_path . 'views/admin-home-view.php'; 
include $base_path . 'partions/footer.php';
?>