<?php
require_once './init.php'; 
header('Content-Type: application/json');
$products = $db->query("SELECT ID, Name, Price, Image FROM products WHERE Is_available = 1")->get();
echo json_encode($products);
