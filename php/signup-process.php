<?php
include 'db_connect.php';

$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$contact   = $_POST['contact'];
$email     = $_POST['email'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
  echo "exists"; 
  $check->close();
  $conn->close();
  exit;
}
$check->close();

$sql = "INSERT INTO users (firstname, lastname, contact, email, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $firstname, $lastname, $contact, $email, $password);

echo $stmt->execute() ? "success" : "error";

$stmt->close();
$conn->close();
?>
