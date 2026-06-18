<?php
require_once './init.php';
ob_clean();

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    echo json_encode($_SESSION['user'], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'error'   => true,
        'message' => 'لم يتم تسجيل الدخول'
    ], JSON_UNESCAPED_UNICODE);
}

exit;
?>