<?php
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

session_start();
$config = require BASE_PATH . 'config.php';

// 3. استدعاء الملفات الأساسية باستخدام الثابت BASE_PATH
require_once BASE_PATH . 'Database.php';
require_once BASE_PATH . 'functions.php'; 
require_once BASE_PATH . 'Response.php';

// 4. جلب بيانات الأدمن
$db = new Database($config); // مررنا الـ config للـ Database لو بتحتاجه هناك
$adminData = $db->query("SELECT Name, Profile_picture FROM users WHERE ID = 2")->statement->fetch();

$current_admin_name = $adminData['Name'] ?? 'Guest';
// هنا بنستخدم base_url من الـ config للروابط اللي هتطلع في الـ HTML
$current_admin_image = $config['base_url'] . str_replace('\\', '/', $adminData['Profile_picture'] ?? '');

// 5. استدعاء الـ Router
require BASE_PATH . 'router.php';