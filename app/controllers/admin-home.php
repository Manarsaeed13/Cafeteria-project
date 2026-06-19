<?php

require_once BASE_PATH . 'Database.php';

$db = new Database(); 

$users    = $db->query("SELECT Name, role FROM users")->get();
$rooms    = $db->query("SELECT Room_number FROM rooms")->get();
$products = $db->query("SELECT * FROM products")->get();

include BASE_PATH . 'partions/admin-navbar.php';
include BASE_PATH . 'views/admin-home-view.php';
include BASE_PATH . 'partions/footer.php';