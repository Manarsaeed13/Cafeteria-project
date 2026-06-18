<?php
require_once './init.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user']['ID'] ?? 1;
$room_id = $data['room_id'];
$notes   = $data['notes'] ?? '';
$cart    = $data['cart'];
$total   = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

try {
    $db->query("INSERT INTO orders (User_id, Room_id, Notes, Total_price) VALUES (?, ?, ?, ?)",
        [$user_id, $room_id, $notes, $total]);
    
    $order_id = $db->connection->lastInsertId();

    foreach ($cart as $item) {
        $db->query("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)",
            [$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
