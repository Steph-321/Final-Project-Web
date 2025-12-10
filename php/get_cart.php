<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT cid, product_name, product_image, price, quantity 
        FROM cart WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

$stmt->close();
$conn->close();
?>
