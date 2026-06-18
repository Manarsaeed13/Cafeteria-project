<?php
session_start();
require 'Database.php';
$config = require 'config.php';
$db = new Database($config, 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    $image = $_FILES['image'];
    $image_path = 'images/' . time() . '_' . $image['name'];
    
    if (move_uploaded_file($image['tmp_name'], $image_path)) {

    $db->query("INSERT INTO products (Name, Price, Image, Category_id) VALUES (:name, :price, :image, :cat_id)", [
            'name' => $name,
            'price' => $price,
            'image' => $image_path,
            'cat_id' => $category_id
        ]);
        
        header('Location: all_products_view.php');
        exit();
    }
}
