<?php
include 'db_connect.php';

$usernameOrEmail = $_POST['email']; // can be email or contact
$password        = $_POST['password'];

$sql = "SELECT * FROM users WHERE email=? OR contact=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
  if (password_verify($password, $user['password'])) {
    echo "success";
  } else {
    echo "invalid"; // wrong password
  }
} else {
  echo "notfound"; // no user found
}

$stmt->close();
$conn->close();
?>
