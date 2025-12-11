<?php
include("db_connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

$user_id      = $_SESSION['user_id'];
$name         = $_POST['name'];
$contact      = $_POST['contact'];
$location     = $_POST['location'];
$address      = $_POST['address'];
$product_name = $_POST['product_name'];
$variant      = $_POST['variant'];
$quantity     = (int)$_POST['quantity'];
$unit_price   = (float)$_POST['unit_price'];
$total        = (float)$_POST['total'];
$delivery_fee = 50.00;
$grand_total  = $total + $delivery_fee;
$order_date   = date("Y-m-d H:i:s");

$sql = "INSERT INTO orders 
        (user_id, product_name, variant, quantity, unit_price, total, grand_total, order_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issiddds", 
    $user_id, 
    $product_name, 
    $variant, 
    $quantity, 
    $unit_price, 
    $total, 
    $grand_total, 
    $order_date
);

if ($stmt->execute()) {
    header("Location: order.php?success=1");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
