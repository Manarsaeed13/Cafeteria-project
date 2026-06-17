<?php
require_once __DIR__ . '/../../Database.php';
$db = new Database();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $db->query("DELETE FROM users WHERE ID = :id", ['id' => $data['id']]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
}