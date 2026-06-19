<?php
if (!isset($db)) {
    require_once 'Database.php';
    $config = require 'config.php';
    $db = new Database($config);
}
$products = $db->query("SELECT products.*, categories.Name as cat_name FROM products JOIN categories ON products.Category_id = categories.ID")->get();
?>
<table class="table">
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= htmlspecialchars($product['Name']) ?></td>
        <td><?= htmlspecialchars($product['Price']) ?> EGP</td>
        <td><img src="/<?= htmlspecialchars($product['Image']) ?>" width="50"></td>
        <td>
            <a href="/edit-product?id=<?= $product['ID'] ?>" class="btn btn-sm btn-dark">Edit</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
