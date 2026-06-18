<?php
session_start();

require_once 'Database.php';
$config = require 'config.php';

$db = new Database($config , 'root', '');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->query("SELECT * FROM users WHERE `E-mail` = :email", ['email' => $email])->find();
    


    if ($user) {
     if (password_verify($password, $user['Password'])) {

       $_SESSION['user'] = [
       'id'    => $user['ID'],
       'name'  => $user['Name'],
       'role'  => $user['Role'],
       'email' => $user['E-mail'],
       'phone' => $user['Phone'] ?? '',
       'image' => $user['Image'] ?? '',
];
        header('Location: index.php');
        exit();
     }else {
        header('location: login_view.php?error=user_not_found');
        exit();
     }
    } else {
        header('location: login_view.php');
        exit();
}
}















?>