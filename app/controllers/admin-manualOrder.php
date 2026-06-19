<?php
require_once __DIR__ . '/../../Database.php';
$config = require_once __DIR__ . '/../../config.php';
$db = new Database($config, 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deliver') {

    $orderId = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);

    if ($orderId) {
        $exists = $db->query(
            "SELECT ID FROM orders WHERE ID = :id AND Status = 'processing'",
            [':id' => $orderId]
        )->get();

        if ($exists) {
            $db->query(
                "UPDATE orders SET Status = 'done' WHERE ID = :id AND Status = 'processing'",
                [':id' => $orderId]
            );
        }
    }
 header("Location: /admin/manual_order");
    exit;
}

$pendingOrders = $db->query("
    SELECT 
        o.ID, 
        o.created_at, 
        u.Name, 
        r.Room_number, 
        u.Ext,
        COALESCE(SUM(oi.quantity * p.Price), 0) AS TotalAmount
    FROM orders o
    JOIN users u       ON o.User_id      = u.ID
    JOIN rooms r       ON o.Room_id      = r.ID
    JOIN order_items oi ON o.ID          = oi.order_id
    JOIN products p    ON oi.product_id  = p.ID
    WHERE o.Status = 'processing'
    GROUP BY o.ID, o.created_at, u.Name, r.Room_number, u.Ext
    ORDER BY o.created_at ASC
")->get();

foreach ($pendingOrders as &$order) {
    $itemsQuery = "SELECT oi.quantity, p.Name, p.Image, p.Price
                   FROM order_items oi
                   JOIN products p ON oi.product_id = p.ID
                   WHERE oi.order_id = :oid";
    $order['items'] = $db->query($itemsQuery, [':oid' => $order['ID']])->get();
}
unset($order);

require __DIR__ . "/../../views/admin-manualOrder.view.php";
