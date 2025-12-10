<?php
session_start();
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$cid = $data['cid'];

$sql = "DELETE FROM cart WHERE cid=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cid);
$stmt->execute();

echo json_encode(["message" => "Item removed"]);

$stmt->close();
$conn->close();
?>
