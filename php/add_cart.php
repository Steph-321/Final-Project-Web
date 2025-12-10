<?php
session_start();
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO cart (user_id, product_name, product_image, price, quantity) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issdi", $user_id, $data['title'], $data['img'], $data['price'], $data['quantity']);
$stmt->execute();

echo json_encode(["message" => "Item added to cart"]);

$stmt->close();
$conn->close();
?>
