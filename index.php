<?php
session_start();

require_once 'Database.php';
require_once 'functions.php'; 
require_once 'Response.php';

//admin photo and name from data base
$db = new Database();
$adminData = $db->query("SELECT Name, Profile_picture FROM users WHERE ID = 2")->statement->fetch();
$current_admin_name = $adminData['Name'] ?? 'Guest';
$current_admin_image = './' . str_replace('\\', '/', $adminData['Profile_picture'] ?? '');


require 'router.php';