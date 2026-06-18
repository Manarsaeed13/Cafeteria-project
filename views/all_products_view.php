<?php
session_start();
require 'Database.php';
$config = require 'config.php';
$db = new Database($config, 'root', '');

$products = $db->query("SELECT * FROM products")->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php require 'partions/admin-navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">All Products</h1>
            <a href="add_product_view.php" class="btn btn-success">+ Add Product</a>
        </div>

        <div class="table-responsive shadow-sm rounded-4 bg-white">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product ): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($product['Name']) ?></td>
                        <td><?= htmlspecialchars($product['Price']) ?> EGP</td>
                        <td class="text-center">
                            <img src="<?= htmlspecialchars($product['Image']) ?>" width="50" class="rounded shadow-sm">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-dark">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
