<?php

return [
    // المسارات الأساسية
    '/'                     => 'app/controllers/admin-home.php',
    '/login'               => 'login_view.php',
    '/login-action'        => 'login_controller.php',

    // مسارات المنتجات
    '/products'            => 'all_products_view.php',
    '/add-product'         => 'add_product_view.php',

    // مسارات الإدارة (الأدمن)
    '/admin-home'          => 'app/controllers/admin-home.php',
    '/admin-users'         => 'app/controllers/users.php',
    '/admin/checks'        => 'app/controllers/admin-checks.php',
    '/admin/manual_order'  => 'app/controllers/admin-manualOrder.php',
    '/admin-profile'       => 'app/controllers/admin-profile.php',

    // العمليات (Actions)
    '/save-order'          => 'app/controllers/save-order.php',
    '/delete-user'         => 'app/controllers/delete-user.php',
    '/update-user'         => 'app/controllers/update-user.php',
    '/add-user'            => 'app/controllers/add-user.php',
];
