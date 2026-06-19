<?php
session_start();
require_once 'Database.php';
$config = require 'config.php';
$db= new Database($config , 'root', '');
$categories = $db->query("SELECT * FROM categories")->get();
?>



<div class="container">
    <div class="card p-5 rounded-4 shadow-lg mx-auto border-0" style="max-width: 900px; background-color: #E7E1B1;">
        <h1 class="fw-bold mb-5 text-success">Add Product</h1>

        <form action="add-product-controller.php" method="POST" id="addProductForm" class="needs-validation" enctype="multipart/form-data" novalidate>
            <!-- Product name -->
            <div class="row mb-4">
                <label for="productName" class="col-md-3 col-form-label fs-5 fw-semibold">Product</label>
                <div class="col-md-7">
                    <input type="text" id="productName" name="product_name" class="form-control form-control-lg border-2 border-success" placeholder="Enter product name" required>
                    <div class="invalid-feedback">Please provide a product name.</div>
                </div>
            </div>

            <!-- Price -->
            <div class="row mb-4">
                <label for="productPrice" class="col-md-3 col-form-label fs-5 fw-semibold">Price</label>
                <div class="col-md-7">
                    <div class="input-group input-group-lg">
                        <input type="number" id="productPrice" name="price" class="form-control border-2 border-success" placeholder="0.00" min="0.01" step="0.01" required>
                        <span class="input-group-text border-2 border-success fw-bold text-success">EGP</span>
                        <div class="invalid-feedback">Please enter a valid price.</div>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="row mb-4">
                <label for="productCategory" class="col-md-3 col-form-label fs-5 fw-semibold">Category</label>
                <div class="col-md-7">
                    <div class="d-flex gap-3 align-items-center">
                        <select id="productCategory" name="category" class="form-select form-select-lg border-2 border-success" required>
                            <option value="" selected disabled>Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['ID'] ?>"><?= htmlspecialchars($category['Name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a href="#" class="text-decoration-none fw-bold text-success">+ Add Category</a>
                    </div>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
            </div>

            <!-- Product Picture -->
            <div class="row mb-5">
                <label for="productImage" class="col-md-3 col-form-label fs-5 fw-semibold">Product Picture</label>
                <div class="col-md-7">
                    <input type="file" id="productImage" name="product_image" class="form-control form-control-lg border-2 border-success" accept="image/*" required>
                    <div class="invalid-feedback">Please upload a product image.</div>
                    <div id="imagePreview" class="mt-3 d-none">
                        <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="row">
                <div class="col-md-7 offset-md-3 d-flex gap-3">
                    <button type="submit" class="btn btn-success btn-lg px-5 text-white fw-bold shadow-sm">Save</button>
                    <button type="reset" class="btn btn-secondary btn-lg px-5 text-white fw-bold shadow-sm">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('productImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('imagePreview');
            preview.querySelector('img').src = event.target.result;
            preview.classList.remove('d-none');
            // Store the base64 string in a data attribute
            document.getElementById('productImage').dataset.base64 = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('addProductForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = this;

    if (!form.checkValidity()) {
        event.stopPropagation();
        form.classList.add('was-validated');
        return;
    }

    const imageBase64 = document.getElementById('productImage').dataset.base64 || 'https://via.placeholder.com/150';

    const newProduct = {
        id: Date.now(),
        name: document.getElementById('productName').value,
        price: document.getElementById('productPrice').value,
        category: document.getElementById('productCategory').options[document.getElementById('productCategory').selectedIndex].text,
        image: imageBase64,
        status: 'Available'
    };

    let products = JSON.parse(localStorage.getItem('cafeteria_products')) || [];
    products.push(newProduct);
    localStorage.setItem('cafeteria_products', JSON.stringify(products));

    alert("Product added successfully!");
    window.location.href = 'index.php?page=all_products';
});
</script>
