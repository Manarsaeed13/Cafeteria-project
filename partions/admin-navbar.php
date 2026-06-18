<style>
    .custom-navbar { background: #FBF5DD; border-radius: 20px; padding: 12px 24px; border: 1px solid rgba(48, 109, 41, 0.2); }
    .brand { font-weight: 800; font-size: 22px; color: #0D530E; text-decoration: none; }
    .nav-link-custom { text-decoration: none; color: #0D530E; font-weight: 700; font-size: 15px; padding: 8px 16px; transition: color 0.3s ease; }
    .nav-link-custom:hover { color: #306D29; }
    .login-btn { background-color: #0D530E; color: #FBF5DD !important; font-weight: 700; padding: 10px 24px; border-radius: 30px; text-decoration: none; }
</style>

<nav class="custom-navbar shadow-sm d-flex align-items-center justify-content-between my-4 container">
    <div class="d-flex align-items-center gap-3">
        <a class="brand d-flex align-items-center gap-2" href="index.php">
            <i class="bi bi-cup-hot-fill"></i> CAFETERIA
        </a>
    </div>

    <div class="d-none d-md-flex nav-links-desktop">
        <a class="nav-link-custom" href="index.php">Home</a>
        <a class="nav-link-custom" href="all_products_view.php">Products</a>
        <a class="nav-link-custom" href="add_product_view.php">Add Product</a>
        <a class="nav-link-custom" href="users_view.php">Users</a>
    </div>

    <div class="d-flex align-items-center gap-3">
        <?php if(isset($_SESSION['user_name'])): ?>
            <span class="fw-bold text-success">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        <?php else: ?>
            <a href="login_view.php" class="login-btn">Log in</a>
        <?php endif; ?>
    </div>
</nav>
