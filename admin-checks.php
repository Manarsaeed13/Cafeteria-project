<?php
require 'Database.php';

$config = require 'config.php';
$db = new Database($config, 'root', '');

$dateFrom = $_GET['dateFrom'] ?? null;
$dateTo   = $_GET['dateTo']   ?? null;
$userId   = $_GET['userId']   ?? 'all';

$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit  = 4;
$offset = ($page - 1) * $limit;

$params = [];

$whereClauses = ["1=1"];

if ($dateFrom) {
    $whereClauses[]       = "DATE(o.created_at) >= :dateFrom";
    $params[':dateFrom']  = $dateFrom;
}
if ($dateTo) {
    $whereClauses[]      = "DATE(o.created_at) <= :dateTo";
    $params[':dateTo']   = $dateTo;
}
if ($userId && $userId !== 'all') {
    $whereClauses[]     = "u.ID = :userId";
    $params[':userId']  = $userId;
}

$whereSQL = implode(" AND ", $whereClauses);


$countQuery = "SELECT COUNT(DISTINCT u.ID) as total
               FROM users u
               JOIN orders o      ON u.ID      = o.User_id
               JOIN order_items oi ON o.ID     = oi.order_id
               JOIN products p    ON oi.product_id = p.ID
               WHERE $whereSQL";

$totalRecords = $db->query($countQuery, $params)->find()['total'] ?? 0;
$totalPages   = ceil($totalRecords / $limit);


$query = "SELECT u.ID, u.Name, COALESCE(SUM(oi.quantity * p.Price), 0) AS TotalAmount
          FROM users u
          JOIN orders o       ON u.ID          = o.User_id
          JOIN order_items oi ON o.ID          = oi.order_id
          JOIN products p     ON oi.product_id = p.ID
          WHERE $whereSQL
          GROUP BY u.ID, u.Name
          ORDER BY u.Name ASC
          LIMIT $limit OFFSET $offset";

$usersSummary = $db->query($query, $params)->get();

$userOrders = [];
if (!empty($usersSummary)) {
    foreach ($usersSummary as $user) {

        $orderParams = [':uid' => $user['ID']];
        $orderWhere  = ["o.User_id = :uid"];

        if ($dateFrom) {
            $orderWhere[]              = "DATE(o.created_at) >= :dateFrom";
            $orderParams[':dateFrom']  = $dateFrom;
        }
        if ($dateTo) {
            $orderWhere[]             = "DATE(o.created_at) <= :dateTo";
            $orderParams[':dateTo']   = $dateTo;
        }

        $orderWhereSQL = implode(" AND ", $orderWhere);

        $orderQuery = "SELECT o.ID, o.created_at,
                              COALESCE(SUM(oi.quantity * p.Price), 0) AS Amount
                       FROM orders o
                       JOIN order_items oi ON o.ID          = oi.order_id
                       JOIN products p     ON oi.product_id = p.ID
                       WHERE $orderWhereSQL
                       GROUP BY o.ID, o.created_at
                       ORDER BY o.created_at DESC";

        $orders = $db->query($orderQuery, $orderParams)->get();

        foreach ($orders as &$order) {
            $itemsQuery = "SELECT oi.quantity, p.Name, p.Image, p.Price
                           FROM order_items oi
                           JOIN products p ON oi.product_id = p.ID
                           WHERE oi.order_id = :oid";
            $order['items'] = $db->query($itemsQuery, [':oid' => $order['ID']])->get();
        }
        unset($order);

        $userOrders[$user['ID']] = $orders;
    }
}

$allUsersList = $db->query("SELECT ID, Name FROM users WHERE role = 'user' ORDER BY Name ASC")->get();

require "admin-checks.view.php";
