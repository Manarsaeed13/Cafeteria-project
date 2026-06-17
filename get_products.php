<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'init.php';
$products = $db->query("SELECT * FROM products")->get();
header('Content-Type: application/json');
echo json_encode($products);
?>