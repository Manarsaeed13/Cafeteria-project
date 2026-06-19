<?php
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: /products'); exit(); }

$product = $db->query("SELECT * FROM products WHERE ID = :id", ['id' => $id])->find();
if (!$product) { abort(404); }

$categories = $db->query("SELECT * FROM categories")->get();
?>
<form action="/update-product-action" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $product['ID'] ?>">
    <input type="text" name="name" value="<?= htmlspecialchars($product['Name']) ?>" class="form-control">
    <input type="number" name="price" value="<?= $product['Price'] ?>" class="form-control">
    <select name="category_id" class="form-select">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['ID'] ?>" <?= $cat['ID'] == $product['Category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['Name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-success">Update Product</button>
</form>
