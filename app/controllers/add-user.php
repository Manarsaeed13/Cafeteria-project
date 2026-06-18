<?php

require_once __DIR__ . '/../../Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['Name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $ext      = $_POST['extension'];
    $room_id  = $_POST['Room_ID'];

    $profile_picture = 'images/default_avatar.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $target_dir  = BASE_PATH . "images/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = 'images/' . basename($_FILES["profile_picture"]["name"]);
    }

    $db->query("INSERT INTO users (Name, `E-mail`, Password, Profile_picture, role, Ext, Room_ID) 
                VALUES (?, ?, ?, ?, 'user', ?, ?)", [
        $name, $email, $password, $profile_picture, $ext, $room_id
    ]);

    $config = require BASE_PATH . 'config.php';
    header('Location: ' . $config['base_url'] . 'admin-users');
    exit();
}

$rooms = $db->query("SELECT * FROM rooms")->get();

include __DIR__ . '/../../partions/admin-navbar.php';
require __DIR__ . '/../../views/add_user.view.php';
include  __DIR__ .'/../../partions/footer.php';
?>
