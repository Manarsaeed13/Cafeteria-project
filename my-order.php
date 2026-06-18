<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$conn = new mysqli("localhost", "root", "", "cafeteria", 3306);
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    $check_status = $conn->query("SELECT status FROM orders WHERE id = $cancel_id");
    if ($check_status && $row = $check_status->fetch_assoc()) {
        if ($row['status'] == 'processing') {
            $conn->query("DELETE FROM orders WHERE id = $cancel_id");
            echo "<script>alert('Order cancelled successfully.'); window.location.href='my-order.php';</script>";
        }
    }
}
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 
$query = "SELECT o.id AS order_id, o.order_date, o.status, o.room_no, o.total_price, p.name AS product_name, p.price AS product_price, p.image, oi.quantity FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = $user_id ORDER BY o.order_date DESC";
$result = $conn->query($query);
$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $oid = $row['order_id'];
        if (!isset($orders[$oid])) {
            $orders[$oid] = [ 'order_date' => $row['order_date'], 'status' => $row['status'], 'room_no' => $row['room_no'], 'total_price' => $row['total_price'], 'items' => [] ];
        }
        $orders[$oid]['items'][] = [ 'name' => $row['product_name'], 'price' => $row['product_price'], 'image' => $row['image'], 'quantity' => $row['quantity'] ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>My Orders</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { background-color: #FBF5DD; } .table-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 85%; margin: 0 auto 50px; } h2 { color: #0D530E; font-weight: bold; margin-bottom: 25px; } .table th { background-color: #0D530E; color: white; text-align: center; } .table td { vertical-align: middle; text-align: center; } .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 8px; } .product-item { display: inline-block; text-align: left; margin: 5px; padding: 5px; border: 1px solid #eee; border-radius: 5px; } </style>
</head>
<body>

<?php include("partions/user-navbar.php"); ?>
<?php include("partions/user-sidebar.php"); ?>

<div class="container-fluid mt-4">
    <div class="table-container">
        <h2>My Orders</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr><th>Order Date</th><th>Status</th><th>Room</th><th>Items</th><th>Total Price</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="6">No orders found.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order_id => $info): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($info['order_date']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($info['status']); ?></span></td>
                            <td><?php echo htmlspecialchars($info['room_no']); ?></td>
                            <td>
                                <?php foreach ($info['items'] as $item): ?>
                                    <div class="product-item">
                                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" class="product-img">
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong> (x<?php echo $item['quantity']; ?>)
                                    </div>
                                <?php endforeach; ?>
                            </td>
                            <td><strong><?php echo $info['total_price']; ?> EGP</strong></td>
                            <td>
                                <?php if ($info['status'] == 'processing'): ?>
                                    <a href="my-order.php?cancel_id=<?php echo $order_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this order?');">Cancel</a>
                                <?php else: ?> <button class="btn btn-sm btn-secondary" disabled>N/A</button> <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>