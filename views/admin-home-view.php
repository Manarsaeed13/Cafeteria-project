<?php
/** @var array $rooms */
/** @var array $users */
/** @var array $products */
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cafeteria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="/cafetaria-project/public/css/admin-home.css">
</head>
<body>

<div class="container-fluid px-4 px-md-5 my-5">
  <div class="row g-5">
    <div class="col-lg-5">
      <div class="card order-card p-4 shadow-sm border-0">
        <h3 class="fw-bold mb-4">Current Order</h3>
        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
          <table class="table table-borderless align-middle mb-0">
            <tbody id="cart-items"><tr><td class="text-center text-muted py-4">No items added yet.</td></tr></tbody>
          </table>
        </div>
        <div id="cart-warning" class="text-danger fw-bold small mt-1 d-none">Please add at least one product!</div>
        <hr class="my-4">
        <div class="mb-4">
          <label class="fw-bold text-secondary">Notes</label>
          <textarea class="form-control bg-light" id="order-notes" rows="2"></textarea>
        </div>
        <div class="mb-4">
          <label class="fw-bold text-secondary">Room</label>
          <select class="form-select bg-light" id="room-select">
            <option selected disabled value="">Choose Room...</option>
            <?php foreach($rooms as $room): ?>
              <option value="<?= $room['Room_number'] ?>">Room <?= $room['Room_number'] ?></option>
            <?php endforeach; ?>
          </select>
          <div id="room-warning" class="text-danger fw-bold small mt-1 d-none">Please select a room!</div>
        </div>
        <div class="d-flex justify-content-between p-3 bg-light rounded mb-4">
          <span class="h4 fw-bold">Total:</span>
          <span class="h3 fw-bolder text-success"><span id="total-price">0</span> EGP</span>
        </div>
   
        <button class="btn confirm-btn w-100 py-3 fw-bold shadow-sm" id="confirmBtn">Confirm Order</button>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card menu-card p-4 shadow-sm border-0">
        <div class="row g-3 mb-4 align-items-end">
          <div class="col-md-6">
            <label class="fw-bold text-secondary">User</label>
            <select class="form-select bg-light" id="user-select">
              <option selected disabled value="">Choose User...</option>
              <?php foreach($users as $user): ?>
                <?php if (isset($user['role']) && $user['role'] == 'user'): ?>
                  <option value="<?= $user['Name'] ?>"><?= $user['Name'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
            <div id="user-warning" class="text-danger fw-bold small mt-1 d-none">Please select a user!</div>
          </div>
          <div class="col-md-6">
            <label class="fw-bold text-secondary">Search</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
              <input type="text" id="search-input" class="form-control bg-light border-start-0" placeholder="Search product...">
            </div>
          </div>
        </div>

       <div class="row row-cols-2 row-cols-sm-3 g-4" id="products-container">
    <?php foreach($products as $product): ?>
        <div class="col product-col">
            <div class="product-item text-center p-3 position-relative border rounded-3 bg-white shadow-sm" 
                 style="cursor: pointer;" 
                 onclick="addToCart({id: <?= $product['ID'] ?>, name: '<?= $product['Name'] ?>', price: <?= $product['Price'] ?>})">
                
                <div class="img-wrapper d-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle bg-light border" style="width: 80px; height: 80px; overflow: hidden;">
                    <img src="<?= $product['Image'] ?>" 
                         alt="<?= $product['Name'] ?>" 
                         class="img-fluid w-100 h-100 object-fit-cover" 
                         onerror="this.src='https://via.placeholder.com/150';">
                </div>
                
                <span class="badge bg-success position-absolute top-0 end-0 m-2 px-2 py-1 fs-7 rounded-pill"><?= $product['Price'] ?> LE</span>
                <p class="product-name fw-bold text-dark mb-0 mt-2"><?= $product['Name'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/admin-home.js"></script>
</body>
</html>