<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . '/../../Database.php';

$db = new Database();


$data = json_decode(file_get_contents('php://input'), true);


if (empty($data['cart']) || empty($data['user']) || empty($data['room'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit;
}


$users = $db->query("SELECT ID FROM users WHERE Name = ?", [$data['user']])->get();
$rooms = $db->query("SELECT ID FROM rooms WHERE Room_number = ?", [$data['room']])->get();

if (empty($users) || empty($rooms)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'User or Room not found']);
    exit;
}

$user_id = $users[0]['ID'];
$room_id = $rooms[0]['ID'];
$notes   = $data['notes'] ?? '';

$total = 0;
foreach ($data['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}


$db->query(
    "INSERT INTO orders (User_id, Room_id, Notes, Total_price, Status, created_at)
     VALUES (?, ?, ?, ?, 'processing', NOW())",
    [$user_id, $room_id, $notes, $total]
);

$order_id = $db->connection->lastInsertId();

foreach ($data['cart'] as $item) {
    $db->query(
        "INSERT INTO order_items (order_id, product_id, quantity, unit_price)
         VALUES (?, ?, ?, ?)",
        [$order_id, $item['id'], $item['quantity'], $item['price']]
    );
}

echo json_encode(['success' => true, 'order_id' => $order_id]);