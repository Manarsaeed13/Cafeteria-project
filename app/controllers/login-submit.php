<?php
require_once BASE_PATH . 'Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->query("SELECT * FROM users WHERE `E-mail` = :email", ['email' => $email])->statement->fetch();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id']   = $user['ID'];
        $_SESSION['user_name'] = $user['Name'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: ' . $config['base_url'] . 'admin-home');
        exit();
    } else {
        header('Location: ' . $config['base_url'] . 'login?error=invalid');
        exit();
    }
}