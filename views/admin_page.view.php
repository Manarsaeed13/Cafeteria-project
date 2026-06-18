<?php
$admin_name = $admin_profile_data["Name"] ?? "Admin";
$admin_email = $admin_profile_data["E-mail"] ?? "N/A";
$admin_role = $admin_profile_data["role"] ?? "Admin";
$admin_ext = $admin_profile_data["Ext"] ?? "N/A";
$admin_img = './' . str_replace('\\', '/', $admin_profile_data["Profile_picture"] ?? 'images/default_avatar.png');
?>
?>
<link rel="stylesheet" href="public/css/admin-profile.css">
<div class="container mt-4">
    <div class="profile-header bg-white p-4 rounded-4 shadow-sm mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold text-success mb-0">My Profile</h1>
            <p class="text-muted mb-0">Welcome back, <?= htmlspecialchars($admin_name) ?>!</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <img src="<?= $admin_img ?>" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
            <h5 class="mb-0 text-success fw-bold"><?= htmlspecialchars($admin_name) ?></h5>
        </div>
    </div>

    <div class="profile-card bg-white p-4 rounded-4 shadow-sm mb-4">
        <div class="row align-items-center">
            <div class="col-md-auto text-center">
                <img src="<?= $admin_img ?>" class="rounded-circle border border-4 border-success" style="width: 130px; height: 130px; object-fit: cover;">
            </div>
            <div class="col-md">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h2 class="fw-bold text-success mb-0"><?= htmlspecialchars($admin_name) ?></h2>
                    <span class="badge bg-warning text-dark"><?= ucfirst($admin_role) ?></span>
                </div>
                <p class="mb-2"><i class="bi bi-envelope text-muted me-2"></i> <?= htmlspecialchars($admin_email) ?></p>
                <p class="mb-0"><i class="bi bi-telephone text-muted me-2"></i> +20 <?= htmlspecialchars($admin_ext) ?></p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <a href="/products" class="text-decoration-none">
                <div class="p-4 rounded-4 shadow-sm bg-white border-start border-5 border-warning h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning"><i class="bi bi-cup-hot fs-3"></i></div>
                        <div><p class="text-muted mb-0">Products</p><h3 class="fw-bold mb-0"><?= $products_count ?></h3></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin-users" class="text-decoration-none">
                <div class="p-4 rounded-4 shadow-sm bg-white border-start border-5 border-primary h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary"><i class="bi bi-people fs-3"></i></div>
                        <div><p class="text-muted mb-0">Users</p><h3 class="fw-bold mb-0"><?= $users_count ?></h3></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/checks" class="text-decoration-none">
                <div class="p-4 rounded-4 shadow-sm bg-white border-start border-5 border-danger h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger"><i class="bi bi-cart fs-3"></i></div>
                        <div><p class="text-muted mb-0">Orders Today</p><h3 class="fw-bold mb-0"><?= $orders_today_count ?></h3></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm">
        <h4 class="fw-bold text-success mb-4">Quick Actions</h4>
        <div class="row g-3">
            <div class="col-6 col-md-3"><a href="/products" class="btn btn-light w-100 p-3 rounded-3 border-0" style="background: #FBF5DD;"><i class="bi bi-plus-circle d-block fs-4 mb-2 text-success"></i> Products</a></div>
            <div class="col-6 col-md-3"><a href="/admin-users" class="btn btn-light w-100 p-3 rounded-3 border-0" style="background: #FBF5DD;"><i class="bi bi-people d-block fs-4 mb-2 text-success"></i> Users</a></div>
            <div class="col-6 col-md-3"><a href="/admin/manual_order" class="btn btn-light w-100 p-3 rounded-3 border-0" style="background: #FBF5DD;"><i class="bi bi-cart-plus d-block fs-4 mb-2 text-success"></i> Manual Order</a></div>
            <div class="col-6 col-md-3"><a href="/admin/checks" class="btn btn-light w-100 p-3 rounded-3 border-0" style="background: #FBF5DD;"><i class="bi bi-receipt d-block fs-4 mb-2 text-success"></i> Checks</a></div>
        </div>
    </div>
</div>
