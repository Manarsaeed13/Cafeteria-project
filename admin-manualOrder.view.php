<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria - Current Orders</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/manualOrder.css">
    <style>
        th {
            background-color: #E7E1B1 !important;
            color: #0D530E !important;
            font-size: larger;
        }
        td {
            background-color: #FBF5DD !important;
            color: #0D530E !important;
            font-size: large;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <?php require "partions/admin-navbar.php" ?>

    <h1 class="container order_header">Orders</h1>

    <div class="container w-75">
        <?php if (empty($pendingOrders)): ?>
            <div class="alert alert-success text-center">No pending orders right now.</div>
        <?php else: ?>
            <?php foreach ($pendingOrders as $order): ?>

                <div class="card shadow-sm mb-4" style="border: 2px solid #0D530E; border-radius: 8px;">
                    <div class="card-header p-0" style="background-color: #E7E1B1; border-bottom: 2px solid #0D530E;">
                        <div class="row m-0 text-center align-items-center">
                            <div class="col py-2" style="border-right: 2px solid #0D530E;">
                                <small class="fw-bold" style="color: #0D530E;">Order Date</small><br>
                                <span style="color: #0D530E; font-weight: 600;"><?= htmlspecialchars($order['created_at']) ?></span>
                            </div>
                            <div class="col py-2" style="border-right: 2px solid #0D530E;">
                                <small class="fw-bold" style="color: #0D530E;">Name</small><br>
                                <span style="color: #0D530E; font-weight: 600;"><?= htmlspecialchars($order['Name']) ?></span>
                            </div>
                            <div class="col py-2" style="border-right: 2px solid #0D530E;">
                                <small class="fw-bold" style="color: #0D530E;">Room</small><br>
                                <span style="color: #0D530E; font-weight: 600;"><?= htmlspecialchars($order['Room_number']) ?></span>
                            </div>
                            <div class="col py-2" style="border-right: 2px solid #0D530E;">
                                <small class="fw-bold" style="color: #0D530E;">Ext.</small><br>
                                <span style="color: #0D530E; font-weight: 600;"><?= htmlspecialchars($order['Ext']) ?></span>
                            </div>
                            <div class="col py-2">
                                <form method="POST" action="admin-manualOrder.php" style="margin: 0;">
                                    <input type="hidden" name="action" value="deliver">
                                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['ID']) ?>">
                                    <button type="submit" class="btn btn-success w-75 fw-bold">Deliver</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="background-color: #FBF5DD;">
                        <?php if (!empty($order['items'])): ?>
                            <div class="d-flex flex-wrap justify-content-evenly">
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="text-center position-relative" style="width: 70px;">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark border border-dark z-1">
                                            <?= htmlspecialchars($item['Price']) ?> LE
                                        </span>
                                        <img src="<?= htmlspecialchars($item['Image']) ?>"
                                             alt="<?= htmlspecialchars($item['Name']) ?>"
                                             class="img-fluid rounded border border-dark mb-1 position-relative z-0"
                                             style="height: 60px; object-fit: cover; background-color: white;">
                                        <div style="font-size: 13px; color: #0D530E;" class="fw-bold"><?= htmlspecialchars($item['Name']) ?></div>
                                        <div style="font-size: 15px; color: #0D530E;" class="fw-bold"> <?= htmlspecialchars($item['quantity']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-muted text-center">No items found for this order.</div>
                        <?php endif; ?>

                        <div class="text-end mt-3 fw-bold" style="color: #0D530E; font-size: 16px;">
                            Total: <?= htmlspecialchars($order['TotalAmount']) ?> EGP
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.js"></script>
</body>

</html>
