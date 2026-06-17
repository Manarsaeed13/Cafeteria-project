 <?php
require_once __DIR__ . '/../../Database.php';
$db = new Database(); 
$base_url = '/cafetaria-project/';
$users    = $db->query("SELECT Name, role FROM users")->get();
$rooms    = $db->query("SELECT Room_number FROM rooms")->get();
$products = $db->query("SELECT * FROM products")->get();

$base_path = "D:/my web project/cafetaria-project/";
include $base_path . 'partions/admin-navbar.php';
include $base_path . 'views/admin-home-view.php';
include $base_path . 'partions/footer.php'; 