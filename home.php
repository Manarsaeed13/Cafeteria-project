<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="public/css/home.css">
</head>

<body>
<style>
  body {
    background: #FBF5DD;
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
  }

  /* ========== SIDEBAR ========== */
  .sidebar {
    position: fixed;
    top: 0;
    left: -280px;
    width: 260px;
    height: 100%;
    background: #0D530E;
    z-index: 1050;
    transition: left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 40px 0 30px;
    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
  }

  .sidebar.open {
    left: 0;
  }

  .sidebar .logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 28px 30px;
    border-bottom: 1px solid rgba(255,255,255,0.15);
    margin-bottom: 20px;
  }

  .sidebar .logo i {
    color: #FBF5DD;
    font-size: 30px;
  }

  .sidebar .logo h2 {
    color: #FBF5DD;
    font-size: 22px;
    font-weight: 700;
    margin: 0;
    letter-spacing: 1px;
  }

  .sidebar .menu {
    list-style: none;
    padding: 0 16px;
    margin: 0;
    flex: 1;
  }

  .sidebar .menu li {
    margin-bottom: 6px;
  }

  .sidebar .menu li a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 18px;
    color: rgba(251, 245, 221, 0.8);
    text-decoration: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .sidebar .menu li a:hover {
    background: rgba(255,255,255,0.12);
    color: #FBF5DD;
  }

  .sidebar .menu li a.active {
    background: rgba(255,255,255,0.18);
    color: #FBF5DD;
    font-weight: 600;
  }

  .sidebar .menu li a i {
    font-size: 18px;
    width: 22px;
    text-align: center;
  }

  .sidebar-close-btn {
    position: absolute;
    top: 18px;
    right: 18px;
    background: rgba(255,255,255,0.15);
    border: none;
    color: #FBF5DD;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
  }

  .sidebar-close-btn:hover {
    background: rgba(255,255,255,0.28);
  }

  .sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 1040;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s ease;
  }

  .sidebar-overlay.show {
    opacity: 1;
    pointer-events: all;
  }

  /* ========== NAVBAR ========== */
  .main-navbar {
    width: 85%;
    margin: 30px auto;
    background: #0D530E;
    border-radius: 28px;
    padding: 20px 35px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  .brand {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .menu-icon {
    font-size: 24px;
    color: #FBF5DD;
    cursor: pointer;
    transition: transform 0.2s;
  }

  .menu-icon:hover {
    transform: scale(1.1);
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }

  .logo i {
    color: #FBF5DD;
    font-size: 28px;
  }

  .logo-text {
    color: #FBF5DD;
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  .navbar-nav {
    gap: 30px;
  }

  .nav-link {
    color: #FBF5DD !important;
    font-weight: 600;
    position: relative;
    transition: 0.3s;
    font-size: 17px;
  }

  .nav-link:hover {
    color: #FBF5DD !important;
  }

  .nav-link.active::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -10px;
    width: 100%;
    height: 3px;
    background: #FBF5DD;
    border-radius: 10px;
  }

  .guest-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
  }

  /* ========== LATEST ORDER ICONS ========== */
  .latest-order-item {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #0b5d1e;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    animation: popIn 0.3s ease;
  }

  .latest-order-item:hover {
    transform: scale(1.08);
    box-shadow: 0 3px 10px rgba(13, 83, 14, 0.3);
  }

  .latest-order-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  @keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    70% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
  }

  .latest-empty {
    color: #aaa;
    font-size: 14px;
    font-style: italic;
  }

  /* ========== PRODUCT CARD ========== */
  .product-card {
    cursor: pointer;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 2px solid transparent;
    background: #fff;
  }

  .product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(13,83,14,0.15);
    border-color: #0D530E;
  }

  /* ========== ORDER CARD ========== */
  .order-card, .menu-card {
    border-radius: 20px;
    background: #fff;
  }

  .confirm-btn {
    background: #0D530E;
    color: #FBF5DD;
    border-radius: 12px;
    font-size: 16px;
    border: none;
  }

  .confirm-btn:hover {
    background: #0a4010;
    color: #FBF5DD;
  }

  /* ========== الستايل المخصص للجدول ========== */
  .cart-table-container {
    max-height: 350px; 
    overflow-y: auto;
    margin-bottom: 20px;
  }

  .btn-minus {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 14px;
  }

  .btn-plus {
    background-color: #4cae4c;
    color: white;
    border: none;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 14px;
  }

  .btn-delete {
    color: #d9534f;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
    font-family: sans-serif;
  }
  
  .cart-qty-val {
    font-weight: bold;
    display: inline-block;
    min-width: 20px;
    text-align: center;
  }

  .cart-item-name {
    font-weight: 600;
    color: #333;
  }

  .cart-item-price {
    font-weight: 600;
    color: #555;
  }

  @media (max-width: 991px) {
    .main-navbar { width: 95%; }
    .navbar-nav { margin-top: 20px; gap: 10px; }
  }
</style>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="mainSidebar">
  <button class="sidebar-close-btn" id="sidebarCloseBtn">
    <i class="fa-solid fa-xmark"></i>
  </button>
  <div class="logo">
    <i class="fa-solid fa-mug-hot"></i>
    <h2>Cafe</h2>
  </div>
  <ul class="menu">
    <li><a href="#"><i class="fa-solid fa-house"></i><span>Home</span></a></li>
    <li><a href="#"><i class="fa-solid fa-bag-shopping"></i><span>Orders</span></a></li>
    <li><a href="#" class="active"><i class="fa-solid fa-user"></i><span>My Profile</span></a></li>
  </ul>
</div>

<nav class="navbar navbar-expand-lg main-navbar">
  <div class="container-fluid">
    <div class="brand">
      <i class="fa-solid fa-bars menu-icon" id="sidebarToggleBtn"></i>
      <a href="#" class="logo">
        <i class="fa-solid fa-mug-hot"></i>
        <span class="logo-text">CAFETERIA</span>
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">My Orders</a></li>
      </ul>
    </div>
    <div class="d-flex align-items-center gap-3">
      <img src="images/user.jpeg" class="guest-img">
      <strong class="d-none d-sm-inline" style="color:#FBF5DD;">Ahmed Mohamed</strong>
    </div>
  </div>
</nav>

<div class="container-fluid px-4 px-md-5 my-5">
  <div class="row g-5">
    
    <div class="col-lg-5 border-divider pe-lg-5">
      <div class="card order-card p-4 shadow-sm border-0">
        <div class="table-responsive cart-table-container">
          <table class="table align-middle mb-0">
            <tbody id="cart-items">
              </tbody>
          </table>
        </div>

        <div id="cart-warning" class="text-danger fw-bold small mt-1 d-none">Please add at least one product to your order!</div>
        <hr class="my-4">

        <div class="mb-4">
          <label for="order-notes" class="form-label fw-bold text-secondary">Notes</label>
          <textarea class="form-control bg-light" id="order-notes" rows="3" placeholder="1 Tea Extra Sugar..."></textarea>
        </div>

        <div class="mb-4">
          <label for="room-select" class="form-label fw-bold text-secondary">Room</label>
          <select class="form-select bg-light" id="room-select">
            <option selected disabled value="">Choose Room...</option>
          </select>
          <div id="room-warning" class="text-danger fw-bold small mt-1 d-none">Please select a room number!</div>
        </div>

        <div class="total-box d-flex justify-content-between align-items-center p-3 bg-light rounded-3 mb-4">
          <span class="total-text h4 mb-0 fw-bold">Total:</span>
          <div>
            <span class="total-price h3 mb-0 fw-bolder text-success" id="total-price">0</span>
            <span class="egp fw-bold text-success ms-1">EGP</span>
          </div>
        </div>

        <button class="btn confirm-btn w-100 py-3 fw-bold shadow-sm" id="confirmBtn">Confirm Order</button>
      </div>
    </div>

    <div class="col-lg-7 ps-lg-5">
      <div class="card menu-card p-4 shadow-sm border-0">
        <div class="mb-4">
          <h5 class="fw-bold text-secondary mb-3">Latest Order</h5>
          <div id="latest-order-container" class="d-flex gap-3 align-items-center flex-wrap">
            <span class="latest-empty">No items yet — tap a product to add!</span>
          </div>
        </div>

        <hr class="my-4">

          <div class="col-md-6">
            <label class="form-label fw-bold text-secondary">Search</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
              <input type="text" id="search-input" class="form-control bg-light border-start-0" placeholder="Search product...">
            </div>
          </div>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 g-4" id="products-container">
            <?php 
            // الكود ده بيضمن إن لو عندك مصفوفة منتجات ممررة من السيرفر مسبقاً يتم بناؤها كـ Fallback فوراً
            if (isset($products) && (is_array($products) || is_object($products))) {
                foreach ($products as $product) {
                    $safeName = htmlspecialchars($product['Name'], ENT_QUOTES, 'UTF-8');
                    $safeImg = htmlspecialchars($product['Image'], ENT_QUOTES, 'UTF-8');
                    echo "
                    <div class='col'>
                      <div class='card product-card h-100 border-0 shadow-sm text-center p-3'
                           onclick=\"addToCart({$product['ID']}, '{$safeName}', {$product['Price']}, '{$safeImg}')\">
                        <img src='{$safeImg}' class='mx-auto mb-2' alt='{$safeName}' style='width:90px;height:90px;object-fit:cover;border-radius:50%;'>
                        <h6 class='fw-bold mb-1' style='font-size:14px;'>{$safeName}</h6>
                        <span class='badge' style='background:#0D530E;font-size:13px;'>{$product['Price']} EGP</span>
                      </div>
                    </div>";
                }
            }
            ?>
        </div>
      </div>
    </div>

  </div>
</div>

<div id="footer-placeholder"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/sidebar.js"></script>

</body>
</html>