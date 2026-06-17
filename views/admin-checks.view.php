<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Checks</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/checks.css">
    <style>
        .custom-pagination .page-link {
            color: #0D530E;
            background-color: #ffffff;
            border-color: #E7E1B1;
            margin: 0 4px;
            border-radius: 8px !important;
            font-weight: bold;
        }

        .custom-pagination .page-link:hover {
            background-color: #E7E1B1;
            color: #0D530E;
            border-color: #E7E1B1;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #E7E1B1;
            border-color: #E7E1B1;
            color: #0D530E;
        }
    </style>
</head>

<body>

    <?php require __DIR__ . "/../partions/admin-navbar.php" ?>

    <h1 class="container check_header">Checks</h1>

    <form class="check_form" method="GET" action="admin-checks.php">
        <label for="dateFrom">Date from</label>
        <input type="date" name="dateFrom" id="dateFrom" value="<?= htmlspecialchars($dateFrom ?? '') ?>">

        <label for="DateTo">Date to</label>
        <input type="date" name="dateTo" id="DateTo" value="<?= htmlspecialchars($dateTo ?? '') ?>">

        <select name="userId" class="selectForm">
            <option value="all" <?= ($userId == 'all') ? 'selected' : '' ?>>All Users</option>
            <?php foreach ($allUsersList as $userOpt): ?>
                <option value="<?= $userOpt['ID'] ?>" <?= ($userId == $userOpt['ID']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($userOpt['Name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Filter" class="sumbitForm">
    </form>

    <div class="check_table accordion container w-50" id="myAccordion ">
        <table class="table rounded-4 overflow-hidden mb-0 ">
            <tr>
                <th>User Name</th>
                <th class="text-center">Total Amount</th>
            </tr>

            <?php if (empty($usersSummary)): ?>
                <tr>
                    <td colspan="2" class="text-center">No checks found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usersSummary as $user): ?>
                    <tr>
                        <td><a href="#user-<?= $user['ID'] ?>" data-bs-toggle="collapse" class="text-decoration-none">
                                + <?= htmlspecialchars($user['Name']) ?>
                            </a></td>
                        <td class="text-center"><?= htmlspecialchars($user['TotalAmount']) ?> EGP</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="p-0 border-0">
                            <div class="collapse container" id="user-<?= $user['ID'] ?>" data-bs-parent="#myAccordion">
                                <table class="table table-sm table-bordered m-0" style="background-color: #f9f9f9;">
                                    <caption style="caption-side: top !important; padding-left: 10px;"> <?= htmlspecialchars($user['Name']) ?>'s orders</caption>
                                    <thead>
                                        <tr>
                                            <th>Order Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userOrders[$user['ID']] as $index => $order): ?>

                                            <?php $uniqueTarget = "order-collapse-" . $order['ID'] . "-" . $index; ?>

                                            <tr class="table-light" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#<?= $uniqueTarget ?>">
                                                <td class="fw-bold text-primary">
                                                    <span class="text-success me-1">&#9662;</span> <?= htmlspecialchars($order['created_at']) ?>

                                                </td>
                                                <td class="fw-bold text-success"><?= htmlspecialchars($order['Amount']) ?> EGP</td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" class="p-0 border-0">
                                                    <div class="collapse bg-white" id="<?= $uniqueTarget ?>">
                                                        <div class="d-flex flex-wrap gap-4 p-3 justify-content-center border-bottom border-2 border-success border-opacity-25">

                                                            <?php if (empty($order['items'])): ?>
                                                                <div class="text-muted">No items found</div>
                                                            <?php else: ?>
                                                                <?php foreach ($order['items'] as $item): ?>
                                                                    <div class="text-center position-relative" style="width: 70px;">
                                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark border border-dark z-1">
                                                                            <?= htmlspecialchars($item['Price']) ?> LE
                                                                        </span>
                                                                        <img src="../<?= htmlspecialchars($item['Image']) ?>" alt="<?= htmlspecialchars($item['Name']) ?>" class="img-fluid rounded border border-dark mb-1 position-relative z-0" style="height: 60px; object-fit: cover; background-color: white;">
                                                                        <div style="font-size: 12px; color: #0D530E;" class="fw-bold"><?= htmlspecialchars($item['Name']) ?></div>
                                                                        <div style="font-size: 13px; color: #0D530E;" class="fw-bold">Qty: <?= htmlspecialchars($item['quantity']) ?></div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </table>
    </div>

    <?php if ($totalPages > 0): ?>
        <nav class="mt-4 mb-5">
            <ul class="pagination justify-content-center custom-pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&dateFrom=<?= $dateFrom ?>&dateTo=<?= $dateTo ?>&userId=<?= $userId ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&dateFrom=<?= $dateFrom ?>&dateTo=<?= $dateTo ?>&userId=<?= $userId ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&dateFrom=<?= $dateFrom ?>&dateTo=<?= $dateTo ?>&userId=<?= $userId ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

    <script src="../../js/bootstrap.js"></script>
</body>

</html>