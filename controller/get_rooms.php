<?php
require_once './init.php';
header('Content-Type: application/json');
$rooms = $db->query("SELECT ID, Room_number FROM rooms")->get();
echo json_encode($rooms);