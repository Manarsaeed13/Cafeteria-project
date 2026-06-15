<?php
session_start();

require "functions.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: login_view.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Home</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <?php require 'partions/admin-navbar.php'; ?>

    <div class="container mt-5">
        <div class="alert alert-success">
            <h1>Welcome, <?= xss($_SESSION['user_name']) ?>!</h1>
            <p>You are logged in as: <strong><?= xss($_SESSION['user_role'] ?? 'User') ?></strong></p>
        </div>
        
        <p>This is your cafeteria home page. You can now start managing products and orders.</p>
    </div>

    <?php require 'footer.php'; ?>

    <script src="js/jquery-4.0.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
