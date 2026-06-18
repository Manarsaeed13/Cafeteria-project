<?php

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    $config = require __DIR__ . "/../../config.php";
 header("Location: " . $config['base_url'] . "login");
    exit();
}

$db = new Database();
$admin_id = $_SESSION["user_id"];

$admin_profile_data = $db->query("SELECT Name, `E-mail`, Profile_picture, role, Ext FROM users WHERE ID = :id", [":id" => $admin_id])->statement->fetch();

$products_count = $db->query("SELECT COUNT(ID) AS count FROM products")->statement->fetchColumn();
$users_count = $db->query("SELECT COUNT(ID) AS count FROM users WHERE role = 'user'")->statement->fetchColumn();
$today = date("Y-m-d");
$orders_today_count = $db->query("SELECT COUNT(ID) AS count FROM orders WHERE DATE(created_at) = :today", [":today" => $today])->statement->fetchColumn();

require __DIR__ . "/../../partions/admin-navbar.php";
require __DIR__ . "/../../views/admin-profile-view.php";
require __DIR__ . "/../../partions/footer.php";