<?php
header("Content-Type: application/json");


$host = "localhost";
$user = "root";
$pass = "";
$dbname = "cafeteria_db"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}


$sql = "SELECT p.ID, p.Name, p.Price, p.Image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.ID
        WHERE oi.order_id = (SELECT MAX(ID) FROM orders)"; 

$result = $conn->query($sql);

$latest_items = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $latest_items[] = [
            "ID"    => (int)$row['ID'],
            "Name"  => $row['Name'],
            "Price" => (float)$row['Price'],
            "Image" => $row['Image']
        ];
    }
}

echo json_encode($latest_items);

$conn->close();
?>