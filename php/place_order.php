<?php
session_start();
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user_id'];
$item_ids = $data['items'];

// Calculate total
$total = 0;
foreach ($item_ids as $cid) {
    $sql = "SELECT price, quantity FROM cart WHERE cid=? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cid, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $total += $row['price'] * $row['quantity'];
    }
    $stmt->close();
}

// Insert into orders
$order_sql = "INSERT INTO orders (user_id, total, order_date) VALUES (?, ?, NOW())";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("id", $user_id, $total);
$order_stmt->execute();
$order_id = $order_stmt->insert_id;
$order_stmt->close();

// Remove ordered items from cart
foreach ($item_ids as $cid) {
    $del_sql = "DELETE FROM cart WHERE cid=? AND user_id=?";
    $del_stmt = $conn->prepare($del_sql);
    $del_stmt->bind_param("ii", $cid, $user_id);
    $del_stmt->execute();
    $del_stmt->close();
}

echo json_encode(["message" => "Order placed successfully", "order_id" => $order_id]);

$conn->close();
?>
