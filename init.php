<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'functions.php';
require_once 'Database.php';
require_once 'Response.php';
require_once 'router.php';
?>