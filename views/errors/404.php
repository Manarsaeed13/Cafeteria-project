<?php
$config = require dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="<?= $config['base_url'] ?>public/css/bootstrap.min.css">
    <style>
        body { background-color: #F5F0D0; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-success">404</h1>
        <p class="fs-4 text-muted">Page Not Found</p>
       
    </div>
</body>
</html>