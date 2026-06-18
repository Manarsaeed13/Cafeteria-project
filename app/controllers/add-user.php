<?php

require_once __DIR__ . '/../../Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $ext = $_POST['extension'];
    $room_id = $_POST['Room_ID'];
    
    
    $profile_picture = 'images/default_avatar.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = $target_file;
    }

   
    $db->query("INSERT INTO users (Name, `E-mail`, Password, Profile_picture, role, Ext, Room_ID) 
                VALUES (?, ?, ?, ?, 'user', ?, ?)", [
        $name, $email, $password, $profile_picture, $ext, $room_id
    ]);

    header('Location: /admin-users');
    exit();
}

$rooms = $db->query("SELECT * FROM rooms")->statement->fetchAll();

include __DIR__ . '/../../partions/admin-navbar.php';
require __DIR__ . '/../../views/add_user.view.php';
include  __DIR__ .'/../../partions/footer.php';
?>
