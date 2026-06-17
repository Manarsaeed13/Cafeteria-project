<?php
$base_path = "D:/my web project/cafetaria-project/";

require_once 'Database.php';
$db = new Database();

$users = $db->query("
    SELECT users.*, rooms.room_number 
    FROM users 
    LEFT JOIN rooms ON users.Room_ID = rooms.id 
    WHERE users.role = 'user'
")->statement->fetchAll();

include $base_path . 'partions/admin-navbar.php';
require $base_path . 'views/users-view.php'; 
include $base_path . 'partions/footer.php';
?>