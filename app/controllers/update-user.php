<?php
require_once __DIR__ . '/../../Database.php';
$db = new Database();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id'], $data['name'], $data['room'], $data['ext'])) {
        echo json_encode(['success' => false, 'message' => 'Missing fields']);
        exit;
    }

    // الـ room في الـ JS بيبعت room_number مش Room_ID
    // لازم نجيب الـ Room_ID من جدول rooms
    $roomResult = $db->query("SELECT id FROM rooms WHERE room_number = :room", ['room' => $data['room']]);
    $roomRow    = $roomResult->statement->fetch();

    if (!$roomRow) {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
        exit;
    }

    $db->query(
        "UPDATE users SET Name = :name, Room_ID = :room_id, Ext = :ext WHERE ID = :id",
        [
            'name'    => $data['name'],
            'room_id' => $roomRow['id'],
            'ext'     => $data['ext'],
            'id'      => $data['id']
        ]
    );

    echo json_encode(['success' => true]);
}